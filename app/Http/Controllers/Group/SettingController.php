<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\PendingAgenda;
use App\Models\User;
use App\Providers\PDFService;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use LynX39\LaraPdfMerger\Facades\PdfMerger;


class SettingController extends Controller
{

    public function index()
    {
       $locale = Session::get('locale');
        return view('settings.index',array(
            'locale'=>$locale
        ));
    }

    public function editProfile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('settings.editProfile', array(
            'user' => $user
        ));
    }

    public function updateProfile(Request $request)
    {
        
        $user =User::where('id',Auth::user()->id)->first(); ;
        if ($request->file('file')) {

            $file = $request->file('file');
            
            if (file_exists(storage_path('app/public/' . $user->file))) {
                unlink(storage_path('app/public/' . $user->file));
            }
            
            $filename = $file->getClientOriginalName();
           
            $path = $file->storeAs("user", time() . $filename);
            $user->file = $path;
            
        } 

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with(['message' => 'Profile Updated']);
    }

    public function changeLanguage(Request $request)
    {  
        Session::put('locale',$request->language);
        return Session::get('locale');

    }

}
