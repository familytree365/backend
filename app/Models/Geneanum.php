<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geneanum extends Model
{
    use HasFactory;

    protected $connection = 'landlord';

    protected $fillable = [
        'remote_id',
        'data',
        'area',
        'db_name',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
