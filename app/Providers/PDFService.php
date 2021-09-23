<?php

namespace App\Providers;

use App\Models\PendingAgenda;
use Illuminate\Support\Facades\Storage;
use stdClass;

class PDFService
{

  public static function store($path, $file)
  {

    $filename = $file->getClientOriginalName();
    $path = $file->storeAs($path, time() . $filename);
    $info = new stdClass();
    $info->path = $path;
    $info->filename = $filename;
    return $info;
  }

  public function merge()
  {
  }

  public static function update($id, $path, $file)
  {
    $agenda = PendingAgenda::where('id', $id)->first();
    
    if ($agenda) {
     
      if(file_exists(storage_path('app/public/' . $agenda->file))){
        
        unlink(storage_path('app/public/' . $agenda->file));
      }
      
      
      $filename = $file->getClientOriginalName();
      $path = $file->storeAs($path, time() . $filename);
      $info = new stdClass();
      $info->path = $path;
      $info->filename = $filename;
      return $info;
    }
  }

  public static function delete($file){
    if(file_exists(storage_path('app/public/' . $file))){
        
      unlink(storage_path('app/public/' . $file));
    }

    return true;
  }
}
