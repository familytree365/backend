<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $connection = 'landlord';

    public function trees()
    {
        return $this->hasMany(App\Model\Tree::class);
    }
}
