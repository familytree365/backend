<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'company_id', 'current_tenant'];

    protected $connection = 'landlord';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
