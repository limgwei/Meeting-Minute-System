<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Group;
use App\Models\Keypoint;
use App\Models\Meeting;
use App\Models\MemberGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
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
       
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        
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
        $agenda = Agenda::where('id',$id)->first();
        $keypoints = $request->keypoints;
        if($keypoints){
            $agenda->keypoints = $keypoints;
        }
        $action_taken = $request->action_taken;
        $taken_by = $request->taken_by;
        if($action_taken){
            $agenda->action_taken = $action_taken;
        }

        if($taken_by){
            $agenda->action_user_id = $taken_by;
        }
        
        $agenda->save();
        return 'Keypoint saved';
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

    public function changeTitle(Request $request,$id){
        $agenda = Agenda::where("id",$id)->first();
        $agenda->title = $request->title;
        $agenda->save();
        return 'success';
    }
}
