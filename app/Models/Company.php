<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $connection = 'landlord';

    protected $fillable = ['name', 'status', 'current_tenant'];

    public function trees()
    {
        return $this->hasMany(Tree::class);
    }
}
