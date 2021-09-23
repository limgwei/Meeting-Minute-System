<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Keypoint;
use App\Models\Meeting;
use App\Models\MemberGroup;
use App\Models\PendingAgenda;
use App\Models\TitleAgenda;
use App\Providers\PDFService;
use Barryvdh\Snappy\Facades\SnappyPdf;
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
        $group_members = MemberGroup::where('group_id',$id)->with('members')->get();
        return view("meeting.add", array(
            'pending_agendas' => $pending_agendas,
            'group_id' => $id,
            'group_members'=> $group_members
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
 
        $count = $request->count;

        $meeting = new Meeting();
        $meeting->group_id = $request->group_id;
        $meeting->title = $request->title;
        $meeting->date = $request->date;
        $meeting->time = $request->time;
        $meeting->venue = $request->venue;
        $meeting->organiser_id = $request->organiser_id;
        $meeting->secretary_id = $request->secretary_id;
        $meeting->approve = 0;
        $meeting->save();

        for ($i = 1; $i <= $count; $i++) {
            $textTitle = "title" . $i;
            $title = $request->$textTitle;
            $titleAgenda = new TitleAgenda();
            $titleAgenda->meeting_id = $meeting->id;
            $titleAgenda->title = $title;
            $titleAgenda->save();


            $textAgenda = $textTitle . "Item";
            $items = $request->$textAgenda;
            if ($items) {
                foreach ($items as $item) {
                    $pending_agenda = PendingAgenda::where('id', $item)->first();
                    $agenda = new Agenda();
                    $agenda->title = $pending_agenda->title;
                    $agenda->file = $pending_agenda->file;
                    $agenda->filename = $pending_agenda->filename;
                    $agenda->description = $pending_agenda->description;
                    $agenda->title_id = $titleAgenda->id;
                    $agenda->video = $pending_agenda->video;
                    $agenda->user_id = $pending_agenda->user_id;
                    $agenda->save();

                    PendingAgenda::where('id', $item)->delete();
                }
            }
        }
        return redirect()->route('meetings.show', $meeting->id)->with(['message' => 'Meeting Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group_id = Meeting::where('id', $id)->first()->group_id;
        $group_members = MemberGroup::where('group_id', $group_id)->with('members')->get();
        $titles = TitleAgenda::where('meeting_id', $id)->get();
        
        foreach ($titles as $title) {
            $agendas = Agenda::where('title_id', $title->id)->with(['users','action_user'])->get();
            
            foreach ($agendas as $agenda) {
                $keypoints = explode("new-]", $agenda->keypoints);
                $agenda_edit = false;
                if ($agenda->user_id == Auth::user()->id) {
                    $agenda_edit = true;
                }
                $agenda->agenda_edit = $agenda_edit;
                $agenda->keypoints = $keypoints;
            }
            $title->agendas = $agendas;
        }

        $user_id = Group::where('id', $group_id)->first()->user_id;
        $is_admin = false;
        if ($user_id == Auth::user()->id) {
            $is_admin = true;
        }
        $meeting = Meeting::where('id', $id)->with(["organiser","secretary"])->first();

        $meeting->time = date('h:i a',strtotime($meeting->time));
        

        foreach ($group_members as $group_member) {
            $member = Attendance::where('meeting_id', $id)->where('is_present', 1)->where('user_id', $group_member->members->id)->first();
            if ($member) {
                $group_member->is_present = true;
            } else {
                $group_member->is_present = false;
            }
        }

        return view("meeting.view", array(
            'meeting_id' => $id,
            'group_members' => $group_members,
            'agendas' => $agendas,
            'is_admin' => $is_admin,
            'titles' => $titles,
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function exportPDF($id)
    {

        

        
       $meeting = Meeting::where("id",$id)->first();
       $name = "meeting.pdf";

       $headers = ['Content-Disposition: inline;filename="'.$name.'"'];

      
        return response()->file(storage_path('app/public/merge/'.$meeting->meeting_file,$headers));
        
    }

    public function checkAttendance(Request $request)
    {
        $meeting_id = $request->meeting_id;
        $group_id = Meeting::where('id', $meeting_id)->first()->group_id;
        $attendances = [];
        if ($request->attendance) {
            $attendances = $request->attendance;
        }

        $group_member_attends = MemberGroup::where('group_id', $group_id)->whereIn('member_id', $attendances)->get();
        $group_member_not_attends = MemberGroup::where('group_id', $group_id)->whereNotIn('member_id', $attendances)->get();



        foreach ($group_member_attends as $group_member_attend) {

            $attend = Attendance::where('user_id', $group_member_attend->member_id)->where('meeting_id', $meeting_id)->first();

            if (!$attend) {
                $attend = new Attendance();
            }

            $attend->meeting_id = $meeting_id;
            $attend->user_id = $group_member_attend->member_id;
            $attend->position = $group_member_attend->position;
            $attend->is_present = 1;
            $attend->save();
        }



        foreach ($group_member_not_attends as $group_member_not_attend) {
            $attend = Attendance::where('user_id', $group_member_not_attend->member_id)->where('meeting_id', $meeting_id)->first();

            if (!$attend) {
                $attend = new Attendance();
            }
            $attend->meeting_id = $meeting_id;
            $attend->user_id = $group_member_not_attend->member_id;
            $attend->position = $group_member_not_attend->position;
            $attend->is_present = 0;
            $attend->save();
        }

        
        $this->generatePDF($meeting_id);


        return redirect()->route('meetings.show', $meeting_id)->with(['message' => 'Meeting Save']);
    }

     function generatePDF($id){

        
        
        $group_id = Meeting::where('id', $id)->with(["organiser","secretary"])->first()->group_id;
        $group_members = MemberGroup::where('group_id', $group_id)->with('members')->get();
        $titles = TitleAgenda::where('meeting_id', $id)->get();

        foreach ($titles as $title) {

            $agendas = Agenda::where('title_id', $title->id)->with(['users','action_user'])->get();
           
            foreach ($agendas as $agenda) {

                $keypoints = explode("new-]", $agenda->keypoints);

                $agenda->keypoints = $keypoints;
            }
            $title->agendas = $agendas;
        }
        $user_id = Group::where('id', $group_id)->first()->user_id;
        $is_admin = false;
        if ($user_id == Auth::user()->id) {
            $is_admin = true;
        }
        $meeting = Meeting::where('id', $id)->first();
        if($meeting->meeting_file){
            PDFService::delete("merge/".$meeting->meeting_file);
        }
        
        $date = new DateTime($meeting->time.' 06/13/2013');
        $date_text = $date->format('d M Y') ;
        $time_text = $date->format('h:i a') ;
    
        $meeting_id = $id;

        $attends = Attendance::where('meeting_id', $id)->where('is_present', 1)->with('users')->get();
        $absents = Attendance::where('meeting_id', $id)->where('is_present', 0)->with('users')->get();
        
        $pdf = SnappyPdf::loadView('meeting.exportPDF', compact(
            'meeting_id',
            'group_members',
            'agendas',
            'is_admin',
            'titles',
            'meeting',
            'attends',
            'absents',
            'date_text',
            'time_text'
        ));
        
       
        $pdf->save(storage_path('app/public/merge/prepare.pdf'), "file");
        
        $title_ids = TitleAgenda::where('meeting_id', $id)->pluck('id')->toArray();
        $agendas = Agenda::whereIn('title_id', $title_ids)->get();

        $pdfMerger = PdfMerger::init();
        $pdfMerger->addPDF(storage_path('app/public/merge/prepare.pdf'), 'all');
        
        foreach ($agendas as $agenda) {
            $pdfMerger->addPDF(storage_path('app/public/' . $agenda->file), 'all');
        }
        $pdfMerger->merge();

        $file_name = time().$meeting->title.".pdf";
        $meeting->meeting_file = $file_name;
        $meeting->save();
        $pdfMerger->save(storage_path('app/public/merge/'.$file_name), "file");
    }
}
