<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingAgenda extends Model
{
    use HasFactory;
    protected $table = "pending_agendas";
    protected $fillable = [
        "title",
        "file",
        "filename",
        "description",
        "title_id",
        "video",
        "user_id",
        "group_id"
    ];
    public function users()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function groups()
    {
        return $this->belongsTo(Group::class, "group_id");
    }
}
