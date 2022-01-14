<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\MemberGroup;
use App\Models\PendingAgenda;
use App\Providers\PDFService;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LynX39\LaraPdfMerger\Facades\PdfMerger;


class PendingAgendaController extends Controller
{
    public function index($id)
    {
        $pending_agendas = PendingAgenda::where('group_id', $id)->with(['users', 'groups'])->orderBy('id', 'desc')->get();
        
        $admin_id = Group::where('id', $id)->first()->user_id;

    
        $create_meeting = false;
        if (Auth::user()->id == $admin_id) {
            $create_meeting = true;
        }
       
        foreach ($pending_agendas as $pending_agenda) {
            if ($pending_agenda->user_id == Auth::user()->id) {
                $pending_agenda->editable = true;
            } else {
                $pending_agenda->editable = false;
            }

            $user_position = MemberGroup::where('member_id',$pending_agenda->users->id)->where('group_id',$id)->first();
            $pending_agenda->position = $user_position->position;
           
        }
       
        return view("pending_agenda.index", array(
            'pending_agendas' => $pending_agendas,
            'group_id' => $id,
            'create_meeting' => $create_meeting
        ));
    }

    public function view($id)
    {

        $pending_agenda = PendingAgenda::where('id', $id)->first();
        
        return view("pending_agenda.view", array(
            'pending_agenda' => $pending_agenda,
            'id' => $id
        ));
    }

    public function add($id)
    {
        return view("pending_agenda.add", array(
            'group_id' => $id
        ));
    }

    public function store(Request $request)
    {
        $allowed = array('pdf');
        $filename = $request->file('file')->getClientOriginalName();
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return redirect()->back()->with(['error' => 'Wrong File Type']);
        }

        $file = $request->file('file');
        $file = PDFService::store("agendas", $file);
       
        // $request->merge([
        //     "file"=>$file->path,
        //     "filename" => $file->filename,
        //     'user_id' => Auth::user()->id
        // ]);
      
        PendingAgenda::create([
            'title'=>$request->title,
            'group_id'=>$request->group_id,
            'description'=>$request->descripton,
            'filename'=>$file->filename,
            'user_id'=>Auth::user()->id,
            'file'=>$file->path
        ]);    

        return redirect()->route('pending_agendas.index', $request->group_id)->with(['message' => 'Pending Agenda Added']);
    }

    public function update(Request $request)
    {
        $allowed = array('pdf');
        if($request->file('file')){
            $filename = $request->file('file')->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                return redirect()->back()->with(['error' => 'Wrong File Type']);
            }
    
            $file = $request->file('file');
            $file = PDFService::update($request->id, "agendas", $file);
    
            $request->merge([
                "file"=>$file->path,
                "filename" => $file->filename,
            ]);

            PendingAgenda::where("id",$request->id)->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'filename'=>$file->filename,
                'file'=>$file->path
            ]);

            return redirect()->back()->with(['message' => 'Edited']);
        }
       
        PendingAgenda::where("id",$request->id)->update([
            'title'=>$request->title,
            'description'=>$request->description
        ]);
        return redirect()->back()->with(['message' => 'Edited']);
    }
}
