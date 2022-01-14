<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = "agendas";
    protected $fillable = [
        "title",
        "file",
        "filename",
        "description",
        "title_id",
        "video",
        "user_id"
    ];
    
    public function titles()
    {
        return $this->belongsTo(TitleAgenda::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function action_user()
    {
        return $this->belongsTo(User::class,'action_user_id');
    }
}
