<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;

use App\Models\MemberGroup;

use Illuminate\Http\Request;


class GroupMemberController extends Controller
{
  public function setAdmin($member_id,$group_id){
     Group::where('id',$group_id)->update(['user_id'=>$member_id]);

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

    MemberGroup::where('group_id',$request->group_id)->where('member_id',$request->user_id)->update(["position"=>$request->position]);
    return redirect()->route('groups.edit',$request->group_id)->with(['message' => 'Position Updated']);
  }


}
