<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleAgenda extends Model
{
    use HasFactory;
    protected $table = "title_agendas";
    protected $fillable = ["meeting_id","title"];
    
    public function meetings()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function agenda(){
        $agendas = $this->hasMany(Agenda::class,"title_id","id")->with("users");
        return  $agendas;
    }
}
