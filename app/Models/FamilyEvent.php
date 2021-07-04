<?php

namespace App\Models;

use FamilyTree365\LaravelGedcom\Models\Place;
use FamilyTree365\LaravelGedcom\Observers\EventActionsObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyEvent extends Event
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'family_events';

    protected $fillable = [
        'family_id',
        'places_id',
        'date',
        'title',
        'description',
        'year',
        'month',
        'day',
        'type',
        'plac',
        'phon',
        'caus',
        'age',
        'husb',
        'wife',
    ];

    public static function boot()
    {
        parent::boot();

        self::observe(new EventActionsObserver());
    }

    public function family()
    {
        return $this->hasMany(Family::class, 'id', 'family_id');
    }

    public function place()
    {
        return $this->hasMany(Place::class, 'id', 'places_id');
    }
}
