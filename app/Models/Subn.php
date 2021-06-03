<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subn extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use HasFactory;
    protected $table = 'subns';

    /**
     * @var array
     */
    protected $fillable = ['subm', 'famf', 'temp', 'ance', 'desc', 'ordi', 'rin'];
}
