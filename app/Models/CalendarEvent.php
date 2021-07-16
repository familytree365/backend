<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = 
        [
            'title', 
            'body', 
            'frequency',
            'start_date',
            'start_time',
            'end_date',
            'end_time',
            'is_all_day',
            'class'
        ];
}
