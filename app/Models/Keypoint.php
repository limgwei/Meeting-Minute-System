<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keypoint extends Model
{
    use HasFactory;
    protected $table = "agenda_keypoints";

    
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
