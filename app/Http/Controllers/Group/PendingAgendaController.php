<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
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

        $pending_agenda = new PendingAgenda();

        $file = $request->file('file');
        $file = PDFService::store("agendas", $file);

        $pending_agenda->file = $file->path;
        $pending_agenda->filename = $file->filename;
        $pending_agenda->title = $request->title;
        $pending_agenda->description = $request->description;
        $pending_agenda->user_id = Auth::user()->id;
        $pending_agenda->group_id = $request->group_id;
        $pending_agenda->save();
        

        return redirect()->route('pending_agendas.index', $request->group_id)->with(['message' => 'Pending Agenda Added']);
    }

    public function update(Request $request)
    {
        $allowed = array('pdf');
        $filename = $request->file('file')->getClientOriginalName();
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return redirect()->back()->with(['error' => 'Wrong File Type']);
        }
        
        $pending_agenda = PendingAgenda::where('id', $request->id)->first();

        $file = $request->file('file');
        $file = PDFService::update($request->id, "agendas", $file);


        $pending_agenda->title = $request->title;
        $pending_agenda->file = $file->path;
        $pending_agenda->filename = $file->filename;
        $pending_agenda->description = $request->description;
        $pending_agenda->save();
        return redirect()->back()->with(['message' => 'Edited']);
    }
}
