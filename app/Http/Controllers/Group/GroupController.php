<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Meeting;
use App\Models\MemberGroup;
use App\Models\PendingAgenda;
use App\Models\TitleAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view("group.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $group = new Group();
        $group->title = $request->title;
        $group->user_id = $user_id;
        while(true){
            $password = Str::random(8);
            $group_password = Group::where('password',$password)->first();
            if(!$group_password){
                break;
            } 
        }
        $group->password = $password;
        $group->save();

        $group_member = new MemberGroup();
        $group_member->member_id = Auth::user()->id;
        $group_member->group_id = $group->id;
        $group_member->save();

        return redirect()->back()->with(['message'=>"Successfully Created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meetings = Meeting::where("group_id",$id)->get();
        return view("group.view",array(
            'group_id'=>$id,
            "meetings"=>$meetings
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
        $group = Group::where('id',$id)->first();
        return view("group.edit",array(
            'group'=>$group
        ));
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
        $group = Group::where('id',$id)->first();
        $group->title = $request->title;
        $group->save();
        return redirect()->back()->with(['message' => 'Model Updated']);
        //
    }

    public function changePassword($id){
        $group = Group::where('id',$id)->first();
        while(true){
            $password = Str::random(8);
            $group_password = Group::where('password',$password)->first();
            if(!$group_password){
                break;
            } 
        }
        $group->password = $password;
        $group->save();
        return response()->json(['message'=>$password]);
    }

    public function joinGroup(Request $request){
        $group = Group::where('password',$request->code)->first();
        if(!$group){
            return redirect()->back()->with(['error' => 'Group Not Found']);
        }

        if($group->user_id == Auth::user()->id){
            return redirect()->back()->with(['error' => 'You are the admin of group']);
        }
        $joinGroup = MemberGroup::where('group_id',$group->id)->where('member_id',Auth::user()->id)->first();
        if($joinGroup){
            return redirect()->back()->with(['error' => 'You have joined the group']);
        }
        $memberGroup = new MemberGroup();
        $memberGroup->group_id = $group->id;
        $memberGroup->member_id = Auth::user()->id;
        $memberGroup->save();
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
       
        MemberGroup::where('group_id',$id)->delete();
        Group::where('id',$id)->delete();
        return redirect()->route('groups.edit')->with(['message' => 'Group Deleted']);
       
    }

    public function ddd(){
        MemberGroup::truncate();
        Agenda::truncate();
        Group::truncate();
        Meeting::truncate();
        Attendance::truncate();
        PendingAgenda::truncate();
        TitleAgenda::truncate();
        return "gg";
    }

    public function members($id){
        return view("group.member",array(
            'group_id'=>$id,
        ));
    }
}
