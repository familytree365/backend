<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    protected $fillable = ['name', 'description', 'repository_id', 'volume', 'page', 'is_active', 'confidence', 'source_id'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

    public function sources()
    {
        return $this->belongsToMany(Source::class);
    }
}
