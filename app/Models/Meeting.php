<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $table = "meetings";
    protected $fillable = [
        "title",
        "date",
        "time",
        "total_minute",
        'approve',
        "link",
        "eventId",
        "venue",
        "group_id",
        "organiser_id",
        "secretary_id",
        'total_end_date_time',
        'total_start_date_time'
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function secretary()
    {
        return $this->belongsTo(User::class, "secretary_id");
    }

    public function organiser()
    {
        return $this->belongsTo(User::class, "organiser_id");
    }

    public function title_agenda()
    {
        $title = $this->hasMany(TitleAgenda::class);
        return  $title;
    }

}
