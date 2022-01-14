<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Group;
use App\Models\MemberGroup;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class GroupMembersDatatable
{
    public function index($id)
    {   
     
        
        $group_members_id = MemberGroup::where('group_id',$id)->pluck('member_id')->toArray();
       
        $users = User::WhereIn('id',$group_members_id)->get();
        
        return Datatables::of($users)
        ->editColumn('positions',function($user)use ($id){
            $group = Group::where('id',$id)->first();
            $group_member = MemberGroup::where('group_id',$id)->where('member_id',$user->id)->first();
            if($group->user_id==$user->id){
                return "Admin(".$group_member->position.")";
            }else{
                return $group_member->position;
            }
        })
        ->editColumn('name',function($user)use ($id){
            $text = '<div class="d-flex align-items-center">';
            $group = Group::where('id',$id)->first();
            if($group->user_id==$user->id){
                return $user->name . "(Admin)";
            }else{
                return $user->name;
            }
           
        })
        ->addColumn('action', function ($user) use($id) {
            $group = Group::where('id',$id)->first();

            if($user->id == $group->user_id){
                return '<div class="d-flex justify-content-center"><button class="btn btn-success mr-2 button_text" data-toggle="modal" onclick="editPosition('.$user->id.')" type="button">Edit Position</button>
                </div>';
                
            }
            else if($group->user_id==Auth::user()->id){
                return '<div class="d-flex justify-content-center">
                <a href="/'.env("base_url").'groups/setAdmin/'.$user->id.'/'.$id.'" class="btn btn-sm btn-primary mr-2 button_text">Set As Admin</a>
                <a href="/'.env("base_url").'groups/deleteMember/'.$user->id.'/'.$id.'" class="btn btn-sm btn-danger mr-2 button_text">Kick</a>
                <button class="btn btn-success mr-2 button_text" data-toggle="modal " onclick="editPosition('.$user->id.')"  type="button">Edit Position</button>
                </div>';
            }
        })
        ->make(true);
            
    }
}
