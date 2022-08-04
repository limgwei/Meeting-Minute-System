<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Keypoint;
use App\Models\Meeting;
use App\Models\MemberGroup;
use App\Models\PendingAgenda;
use App\Models\TitleAgenda;
use App\Models\User;
use App\Providers\GoogleCalendarService;
use App\Providers\PDFService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use DateTime;
// use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use Ramsey\Uuid\Type\Time;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pending_agendas =  PendingAgenda::where('group_id', $id)->with('users')->get();
        $group_members = MemberGroup::where('group_id', $id)->with('members')->get();
        return view("meeting.add", array(
            'pending_agendas' => $pending_agendas,
            'group_id' => $id,
            'group_members' => $group_members
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $group_members = MemberGroup::where("group_id", $request->group_id)->pluck("member_id")->toArray();
        $user = User::whereIn("id", $group_members)->pluck("email")->toArray();

        $minutes = ($request->hour * 60) + $request->minute;
        
        $start_datetime =  Carbon::parse($request->date."T".$request->time);
        $end_datetime = Carbon::parse($request->date."T".$request->time)->addMinutes($minutes);
       
        
        // create google calendar api
        // $link = GoogleCalendarService::insert($request->title, $request->venue, $start_datetime->format("Y-m-d"), $start_datetime->format("H:i:s"), $end_datetime->format("Y-m-d"), $end_datetime->format("H:i:s"),$user);

        //create meeting
        // $request->merge([
        //     "link" => $link[0],
        //     "eventId" => $link[1],
        //     'approve' => 0,
        //     'total_end_date_time' => $end_datetime->format("Y-m-d H:i:s"),
        //     'total_start_date_time' => $start_datetime->format("Y-m-d H:i:s"),
        //     'total_minute'=>$minutes
        // ]);

        $request->merge([
            "link" => 0,
            "eventId" => 1,
            'approve' => 0,
            'total_end_date_time' => $end_datetime->format("Y-m-d H:i:s"),
            'total_start_date_time' => $start_datetime->format("Y-m-d H:i:s"),
            'total_minute'=>$minutes
        ]);


        $meeting = Meeting::create($request->all());

        //handle agenda and pending agenda
        $count = $request->count;
        for ($i = 1; $i <= $count; $i++) {
            $textTitle = "title" . $i;
            if($request->$textTitle!=null){
                $titleAgenda = TitleAgenda::create([
                    "meeting_id" => $meeting->id,
                    "title" => $request->$textTitle
                ]);
                $textAgenda = $textTitle . "Item";
                $items = $request->$textAgenda;
                if ($items) {
                    foreach ($items as $item) {
                        $pending_agenda = PendingAgenda::where('id', $item)->first();
                        $pending_agenda->title_id = $titleAgenda->id;
                        Agenda::create($pending_agenda->toArray());
                        PendingAgenda::where('id', $item)->delete();
                    }
                }
            }
  
        }

      
       
        $meeting->temporary_file = $this->mergePDF($meeting->id);
        $meeting->save();
        return redirect()->route('meetings.show', $meeting->id)->with(['message' => 'Meeting Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get meeting information
        $meeting = Meeting::where("id", $id)->with(["title_agenda", "title_agenda.agenda", "organiser", "secretary"])->first();
        $meeting->member = MemberGroup::where("group_id", $meeting->group_id)->get();

        $meeting->time = date('h:i a', strtotime($meeting->time));
        if ($meeting->end_time) {
            $meeting->end_time = date('h:i a', strtotime($meeting->end_time));
        }

       
        $title_agenda = TitleAgenda::where('meeting_id',$meeting->id)->pluck('id')->toArray();
        $agenda_count = Agenda::whereIn('title_id',$title_agenda)->get();
        $text = "";
        $turn = 0;
        foreach($agenda_count as $count){
            $turn++;
            if($turn==1){
                $text.=$count->id;
            }else{
                $text.=",".$count->id;
            }
           
        }
       
        $meeting->agenda_count = $text;
        
        //check whether login is admin or not
        $user_id = Group::where('id', $meeting->group_id)->first()->user_id;
        $is_admin = false;
        if ($user_id == Auth::user()->id) {
            $is_admin = true;
        }

        //who come and no come
        foreach ($meeting->member as $group_member) {
            $member = Attendance::where('meeting_id', $id)->where('is_present', 1)->where('user_id', $group_member->members->id)->first();
            if ($member) {
                $group_member->is_present = true;
            } else {
                $group_member->is_present = false;
            }
        }

        $newformat = date('d M Y-h:iA', strtotime($meeting->date . ' ' . $meeting->time));
        $meeting->local_time = $newformat;
        $current_time = date("Y-m-d H:i:s");

        $meeting->link_opened = false;
        // if ($meeting->total_start_date_time <= $current_time && $meeting->total_end_date_time >= $current_time) {
        //     $meeting->link_opened = true;
        // }
        

        return view("meeting.view", array(
            'is_admin' => $is_admin,
            'meeting' => $meeting
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meeting = Meeting::where("id", $id)->first();
        $group_members = MemberGroup::where('group_id', $meeting->group_id)->with('members')->get();
        $pending_agendas =  PendingAgenda::where('group_id', $meeting->group_id)->with('users')->get();
       
        $hours =floor($meeting->total_minute/60);         
        $minutes = $meeting->total_minute%60;
        
        return view("meeting.edit", array(
            'meeting' => $meeting,
            'group_members' => $group_members,
            'pending_agendas' => $pending_agendas,
            'hours'=>$hours,
            'minutes'=>$minutes
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
     
        $minutes = $request->hour*60 + $request->minute;
        $start_datetime =  Carbon::parse($request->date."T".$request->time);
        $end_datetime = Carbon::parse($request->date."T".$request->time)->addMinutes($minutes);
        $request->merge([
            'total_end_date_time' => $end_datetime->format("Y-m-d H:i:s"),
            'total_start_date_time' => $start_datetime->format("Y-m-d H:i:s"),
            'total_minute'=>$minutes
        ]);
        Meeting::where("id", $request->id)->update($request->except(['_token','hour','minute']));
        
        return redirect()->back()->with(['message' => 'Meeting Updated']);
    }

    public function exportPDF($id)
    {

        $meeting = Meeting::where("id", $id)->first();
        $name = "meeting.pdf";

        $headers = ['Content-Disposition: inline;filename="' . $name . '"'];

       
        return response()->file(storage_path('app/public/merge/' . $meeting->meeting_file, $headers));
    }

    public function checkAttendance(Request $request)
    {
       
        $meeting_id = $request->meeting_id;
        $group_id = Meeting::where('id', $meeting_id)->first()->group_id;
        $attendances = [];
        if ($request->attendance) {
            $attendances = $request->attendance;
        }

        $group_members = MemberGroup::where("group_id", $group_id)->get();
        foreach ($group_members as $group_member) {
            $attend = Attendance::where('user_id', $group_member->member_id)->where('meeting_id', $meeting_id)->first();

            if (!$attend) {
                $attend = new Attendance();
            }

            $attend->meeting_id = $meeting_id;
            $attend->user_id = $group_member->member_id;
            if ($group_member->position == null) {
                $attend->position = "";
            } else {
                $attend->position = $group_member->position;
            }

            if (in_array($group_member->member_id, $attendances)) {
                $attend->is_present = 1;
            } else {
                $attend->is_present = 0;
            }
            $attend->save();
        }
        $meeting = Meeting::where('id',$meeting_id)->first();
        $meeting->meeting_file =  $this->generatePDF($meeting_id);
        $meeting->save();
       
        return redirect()->route('meetings.show', $meeting_id)->with(['message' => 'Meeting Save']);
    }

    function mergePDF($id)
    {
        $title_ids = TitleAgenda::where('meeting_id', $id)->pluck('id')->toArray();
        $agendas = Agenda::whereIn('title_id', $title_ids)->get();

        $pdfMerger = PdfMerger::init();

        if(count($agendas)!=0){
            foreach ($agendas as $agenda) {
                $pdfMerger->addPDF(storage_path('app/public/' . $agenda->file), 'all');
            }
            $pdfMerger->merge();
            $file_name = time() . $id . ".pdf";
            $pdfMerger->save(storage_path('app/public/temporary/' . $file_name), "file");
            return $file_name;
        }
        else{
            return 'none';
        }
       

    }

    function generatePDF($id)
    {
        $group_id = Meeting::where('id', $id)->with(["organiser", "secretary"])->first()->group_id;

        $titles = TitleAgenda::where('meeting_id', $id)->get();
        $countTitle = 0;

        $countKeypoint = 0;
        foreach ($titles as $title) {
            $countTitle++;

            $preTitle = $countTitle . ".";
            $title->title = $preTitle . $title->title;

            $agendas = Agenda::where('title_id', $title->id)->with(['users', 'action_user'])->get();
            $countAgenda = 0;
            foreach ($agendas as $agenda) {

                $countAgenda++;
                $preAgenda = $preTitle . $countAgenda . ".";
                $agenda->title = $preAgenda . $agenda->title;

            }
            $title->agendas = $agendas;
        }

        $meeting = Meeting::where('id', $id)->first();
        if ($meeting->meeting_file) {
            PDFService::delete("merge/" . $meeting->meeting_file);
        }
        
        $date_text = Carbon::parse($meeting->date)->format('d M Y');
        $time_text = Carbon::parse($meeting->time)->format('h:i a');

        $meeting_id = $id;

        $attends = Attendance::where('meeting_id', $id)->where('is_present', 1)->with('users')->get();
        $absents = Attendance::where('meeting_id', $id)->where('is_present', 0)->with('users')->get();
        $group = Group::where('id',$meeting->group_id)->first();
        $pdf = SnappyPdf::loadView('meeting.exportPDF', compact(
            'meeting_id',
            'titles',
            'meeting',
            'attends',
            'absents',
            'date_text',
            'time_text',
            'group'
        ));

       
        $pdf->save(storage_path('app/public/merge/prepare.pdf'), "file");

        $pdfMerger = PdfMerger::init();
        $pdfMerger->addPDF(storage_path('app/public/merge/prepare.pdf'), 'all');
        if($meeting->temporary_file!="none"){
            $pdfMerger->addPDF(storage_path('app/public/temporary/' .$meeting->temporary_file), 'all');
        }

        $pdfMerger->merge();
   
        $file_name = time() . $meeting->title . ".pdf";
       
        $pdfMerger->save(storage_path('app/public/merge/' . $file_name), "file");
        return $file_name;
       
    }

}
