<?php

namespace App\Http\Controllers\Datatables;


use App\Models\Group;
use App\Models\MemberGroup;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class GroupsDatatable
{
    public function index()
    {  
       

        $group_members_id = MemberGroup::where('member_id',Auth::user()->id)->pluck('group_id')->toArray();
        $groups = Group::WhereIn('id',$group_members_id)->with('user')->get();
        return Datatables::of($groups)
        // $colors = Color::where('status',$request->status)->where('model_id','<>',0)->get();
        // return Datatables::of($colors)
        ->editColumn('user_id',function($group){
            return $group->user->name;
        })
        ->editColumn('created_at',function($group){
            return date("Y-m-d",strtotime($group->created_at));
        })
        ->addColumn('action', function ($group) {
            if($group->user_id==Auth::user()->id){
                return '<div><a href="groups/'.$group->id.'/edit'.'" class="btn btn-sm btn-primary mr-2">Edit</a><a href="groups/'.$group->id.'" class="btn btn-sm btn-primary mr-2">View</a>
                </div>';
            }else{
                return '<div> <a href="groups/'.$group->id.'" class="btn btn-sm btn-primary mr-2">View</a>
                </div>';
            }
           
        })
        ->make(true);
            
    }
}
