<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\InvitationLink;
use App\Models\MemberGroup;
use App\Models\User;
use Google\Service\Classroom\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvitationController extends Controller
{


  public function getNotification()
  {
    $notification = InvitationLink::where(function ($q) {
      $q->where('receiver_id', Auth::user()->id)
        ->where('is_approve', 0)
        ->where('is_seen', 0);
    })->orWhere(function ($q) {
      $q->where('sender_id', Auth::user()->id)
        ->where('is_approve', '<>', 0)
        ->where('is_seen', 0);
    })->count();

    // $notification = InvitationLink::where('receiver_id', Auth::user()->id)->where('is_seen', 0)->count();
    return $notification;
  }

  public function sendInvitation(Request $request)
  {

    $user = User::where('email', $request->email)->first();
    if ($user) {
      $invitation = InvitationLink::where('group_id', $request->group_id)->where('receiver_id', $user->id)->where('is_approve',0)->first();
      if ($invitation) {
        return ['status' => "error", 'message' => 'You have already sent to the user before, please wait for reply'];
      }

      $member = MemberGroup::where('group_id', $request->group_id)->where('member_id', $user->id)->first();
      if (!$member) {
        $invitation = new InvitationLink();
        $invitation->sender_id = Auth::user()->id;
        $invitation->group_id = $request->group_id;
        $invitation->receiver_id = $user->id;
        $invitation->is_seen = 0;
        $invitation->is_approve = 0;
        $invitation->save();
        return ['status' => "success", 'message' => 'The invitation has sent'];
      }
      return ['status' => "error", 'message' => 'The user is already in your team'];
    }
    return ['status' => "error", 'message' => 'User not found'];
  }

  public function getInvitation()
  {

    $invitations = InvitationLink::where(function ($q) {
      $q->where('receiver_id', Auth::user()->id)
        ->where('is_approve', 0);
    })->orWhere(function ($q) {
      $q->where('sender_id', Auth::user()->id)
        ->where('is_approve', '<>', 0);
    })->with(['sender', 'group', 'receiver'])->orderBy('id', 'desc')->get();

    return view('settings.invitation', array(
      'invitations' => $invitations
    ));
  }

  public function updateSeen()
  {
    
    InvitationLink::where(function ($q) {
      $q->where('receiver_id', Auth::user()->id)
        ->where('is_approve', 0);
    })->orWhere(function ($q) {
      $q->where('sender_id', Auth::user()->id)
        ->where('is_approve', '<>', 0);
    })->update(['is_seen' => 1]);

    return 'success';
    // InvitationLink::where('receiver_id', Auth::user()->id)->update(['is_seen' => 1]);
  }

  public function getReply($id, $reply)
  {

    $invitation = InvitationLink::where('id', $id)->first();

    $invitation->update(['is_approve' => $reply,'is_seen'=>0]);
    if ($reply == 1) {

      $member_group = new MemberGroup();
      $member_group->member_id = Auth::user()->id;
      $member_group->group_id = $invitation->group_id;
      $member_group->position = "empty";
      $member_group->save();

      return redirect()->route('groups.show', $invitation->group_id)->with(['message' => 'Invitation Accepted']);
    }

    return redirect()->back()->with(['message' => 'Invitation Rejected']);
  }

  public function a(){
    return view('meeting.a');
  }
}
