<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $gedcom_event_names = [];

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'places_id');
    }

    public function getPlacename()
    {
        return $this->place ? $this->place->title : 'unknown place';
    }

    public function getTitle()
    {
        return $this->gedcom_event_names[$this->title] ?? $this->title;
    }

    public function scopeOrderByDate($query)
    {
        return $query->orderBy('year')->orderBy('month')->orderBy('day');
    }
}
