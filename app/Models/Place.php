<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['description', 'title', 'date'];

    public static function getIdByTitle($title)
    {
        $id = null;
        if (empty($title)) {
            return $id;
        }
        $place = self::query()->where('title', $title)->first();
        if ($place !== null) {
            $id = $place->id;
        } else {
            $place = self::query()->create(compact('title'));
            $id = $place->id;
        }

        return $id;
    }
}
