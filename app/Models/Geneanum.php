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
        'date',
        'name',
        'first_name',
        'sex',
        'father_first_name',
        'father_is_dead',
        'mother_name',
        'mother_first_name',
        'mother_is_dead',
        'observation1',
        'observation2',
        'observation3',
        'observation4',
        'officer',
        'parish',
        'source',
        'update',
    ];
}
