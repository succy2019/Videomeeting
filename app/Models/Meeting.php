<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'room_name',
        'start_time',
        'end_time',
        'meeting_link',
    ];
}
