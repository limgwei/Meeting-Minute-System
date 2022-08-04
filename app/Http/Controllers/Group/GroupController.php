<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGroupRequest;
use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\InvitationLink;
use App\Models\Meeting;
use App\Models\MemberGroup;
use App\Models\PendingAgenda;
use App\Models\TitleAgenda;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use stdClass;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $group_members_id = MemberGroup::where('member_id', Auth::user()->id)->pluck('group_id')->toArray();
        $groups = Group::WhereIn('id', $group_members_id)->with('user')->get();

        return view("group.index", array(
            'groups' => $groups
        ));
    }

    public function store(SaveGroupRequest $request)
    {
        while (true) {
            $password = Str::random(8);
            $group_password = Group::where('password', $password)->first();
            if (!$group_password) {
                break;
            }
        }


        $group = Group::create([
            "title" => $request->title,
            "user_id" => Auth::user()->id,
            "password" => $password
        ]);

        MemberGroup::create([
            "member_id" => Auth::user()->id,
            "group_id" => $group->id,
            "position"=>'Admin'
        ]);

        return redirect()->back()->with(['message' => "Successfully Created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $current_time = date("Y-m-d H:i:s");

        $pending_meetings = Meeting::where("group_id", $id)->where('total_end_date_time', '>=', $current_time)->orderByDesc('total_start_date_time')->get();

        $pass_meetings = Meeting::where("group_id", $id)->where('total_end_date_time', '<', $current_time)->orderByDesc('total_start_date_time')->get();
        
        $pending_count = 0;
        foreach ($pending_meetings as $pending_meeting) {
            $pending_count++;
            $pending_meeting->local_date = date('d M Y', strtotime($pending_meeting->date ));
            $pending_meeting->local_time =date('h:iA', strtotime( $pending_meeting->time));
        }
        if($pending_count<10){
            $pending_count = "0".$pending_count;
        }
        $pending_meetings->count = $pending_count;
        $pass_count = 0;
        foreach ($pass_meetings as $pass_meeting) {
            $pass_count++;
            $pass_meeting->local_date = date('d M Y', strtotime($pass_meeting->date ));
            $pass_meeting->local_time =date('h:iA', strtotime( $pass_meeting->time));
        }
        if($pass_count<10){
            $pass_count = "0".$pass_count;
        }
        $pass_meetings->count = $pass_count;
        $group_user_id = Group::where("id", $id)->first()->user_id;

        return view("group.view", array(
            'group_id' => $id,
            "pending_meetings" => $pending_meetings,
            "pass_meetings" => $pass_meetings,
            "group_user_id" => $group_user_id
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
        $group = Group::where('id', $id)->first();
        return view("group.edit", array(
            'group' => $group
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveGroupRequest $request, $id)
    {

        $group = Group::where('id', $id)->first();

        if ($request->file('file')) {

            $file = $request->file('file');
            
            if($group->file!=null){
                if (file_exists(storage_path('app/public/' . $group->file))) {
                    unlink(storage_path('app/public/' . $group->file));
                }
            }

            $filename = $file->getClientOriginalName();
            $path = $file->storeAs("group_image", time() . $filename);
            $group->file = $path;
            $group->title = $request->title;
            $group->save();
        } else {
            Group::where('id', $id)->update($request->validated());
        }

        return redirect()->back()->with(['message' => 'Group Updated']);
        //
    }

    public function changePassword($id)
    {

        while (true) {
            $password = Str::random(8);
            $group_password = Group::where('password', $password)->first();
            if (!$group_password) {
                break;
            }
        }
        Group::where('id', $id)->update([
            'password' => $password
        ]);

        return response()->json(['message' => $password]);
    }

    public function joinGroup(Request $request)
    {
        $group = Group::where('password', $request->code)->first();
        $result = $this->joinGroupAvailable($group);

        if ($result != "true") {
            return redirect()->back()->with(['error' => $result]);
        }

        MemberGroup::create([
            'group_id' => $group->id,
            'member_id' => Auth::user()->id
        ]);

        return redirect()->back()->with(['message' => 'Group Joined']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $meetings =   Meeting::where('group_id', $id)->get();
        foreach($meetings as $meeting){
            $title_agendas = TitleAgenda::where('meeting_id',$meeting->id)->get();
            foreach($title_agendas as $title_agenda){
                Agenda::where('title_id',$title_agenda->id)->delete();
            }
            TitleAgenda::where('meeting_id',$meeting->id)->delete();
            Attendance::where('meeting_id',$meeting->id)->delete();
        }

        
        InvitationLink::where('group_id', $id)->delete();
        MemberGroup::where('group_id', $id)->delete();
        Group::where('id', $id)->delete();
        Meeting::where('group_id', $id)->delete();

        return redirect()->route('groups.index')->with(['message' => 'Group Deleted']);
    }

    public function ddd()
    {
        MemberGroup::truncate();
        Agenda::truncate();
        Group::truncate();
        Meeting::truncate();
        Attendance::truncate();
        PendingAgenda::truncate();
        TitleAgenda::truncate();
        return "gg";
    }

    public function members($id)
    {
        $members = MemberGroup::where('group_id', $id)->with('members')->get();
       
        $group_admin = Group::where('id',$id)->first()->user_id;
        
        $is_admin = false;
        if($group_admin == Auth::user()->id){
            $is_admin=true;
        }
        return view("group.member", array(
            'members' => $members,
            'group_id' => $id,
            'is_admin'=>$is_admin
        ));
    }

    private function joinGroupAvailable($group)
    {
        if (!$group) {
            return 'Group Not Found';
        }

        if ($group->user_id == Auth::user()->id) {
            return  'You are the admin of group';
        }
        $joinGroup = MemberGroup::where('group_id', $group->id)->where('member_id', Auth::user()->id)->first();
        if ($joinGroup) {
            return 'You have joined the group';
        }

        return "true";
    }

    public function meeting_schedule()
    {

        return view('group.meeting_schedule');
    }

    public function meeting_schedule_action()
    {
        $group_members_id = MemberGroup::where('member_id', Auth::user()->id)->pluck('group_id')->toArray();
        $meetings = Meeting::WhereIn('group_id', $group_members_id)->with('group')->get();
        //  return $meetings;
        $schedule_format = array();
        
        $date_exist = array();
        foreach ($meetings as $meeting) {
            array_push($date_exist, $meeting->date);
            $counts = array_count_values($date_exist);
            $color = $counts[$meeting->date]%3;

            $o = new stdClass();
            $o->id = $meeting->id;
            $newDate = date("F/d/Y", strtotime($meeting->date));
            $o->date = $newDate;
            $o->name = $meeting->title;
            $newformat = date('h:iA', strtotime($meeting->time));
            $o->badge = '<i class="bi bi-alarm-fill"></i> '.$newformat;
            $text = '<i class="bi bi-people-fill"></i> '.$meeting->group->title."<br>".'<i class="bi bi-geo-alt-fill"></i> '.$meeting->venue;
            $o->description =$text;
        
            if($color==0){
                $o->type = "event";
            }else if ($color==1){
                $o->type = "birthday";
            }else{
                $o->type = "holiday";
            }

            array_push($schedule_format, $o);
        }

        return response()->json($schedule_format);
    }

    public function leftGroup($group_id){
        MemberGroup::where("group_id",$group_id)->where('member_id',Auth::user()->id)->delete();
        return redirect()->route('groups.index');
    }
}
