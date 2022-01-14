<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGroup extends Model
{
    use HasFactory;
    protected $table = "group_members";
    protected $fillable = ["member_id","group_id","position"];

    public function members()
    {
        return $this->belongsTo(User::class,"member_id");
    }

}

