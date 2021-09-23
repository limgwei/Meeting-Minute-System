<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingAgenda extends Model
{
    use HasFactory;
    protected $table = "pending_agendas";

    public function users()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function groups(){
        return $this->belongsTo(Group::class,"group_id");
    }
}

