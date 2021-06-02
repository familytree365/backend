<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    /**
     * @var array
     */
    use HasFactory;
    protected $fillable = ['name', 'description', 'company_id', 'current_tenant'];

    protected $connection = 'landlord';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
