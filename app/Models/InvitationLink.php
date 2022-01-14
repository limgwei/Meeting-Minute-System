<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationLink extends Model
{
    use HasFactory;
    protected $table = "invitation_links";

    protected $fillable = [
        "is_approve",
        "is_seen"
    ];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class);
    }
}
