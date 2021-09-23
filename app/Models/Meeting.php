<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $table = "meetings";

    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function secretary(){
        return $this->belongsTo(User::class,"secretary_id");
    }

    public function organiser(){
        return $this->belongsTo(User::class,"organiser_id");
    }
}
