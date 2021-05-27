<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'is_active', 'name'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];
}
