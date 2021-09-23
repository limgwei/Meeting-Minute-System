<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\MemberGroup;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
  public function setAdmin($member_id,$group_id){
    $group = Group::where('id',$group_id)->first();
    $group->user_id = $member_id;
    $group->save();
    return redirect()->route('groups.index')->with(['message' => 'Admin Changed']);
  }

  public function deleteMember($member_id,$group_id){
 
    $member_group = MemberGroup::where('group_id',$group_id)->where('member_id',$member_id)->first();
    if($member_group){
      MemberGroup::where('group_id',$group_id)->where('member_id',$member_id)->delete();

      return redirect()->back()->with(['message' => 'Member Kicked']);
    }
  }

  public function editPosition($member_id,$group_id){
    $member_group = MemberGroup::where('group_id',$group_id)->where('member_id',$member_id)->with('members')->first();
    return view('group.editPosition',array(
      'member_group'=>$member_group
    ));
  }

  public function updatePosition(Request $request){
    $member_group = MemberGroup::where('id',$request->id)->first();
    $member_group->position = $request->position;
    $member_group->save();
   
    return redirect()->route('groups.edit',$member_group->group_id)->with(['message' => 'Position Updated']);
  }
}
