<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleAgenda extends Model
{
    use HasFactory;
    protected $table = "title_agendas";

    
    public function meetings()
    {
        return $this->belongsTo(Meeting::class);
    }
}
