<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name', 'description','company_id','user_id'];

    protected $connection = 'landlord';
}
