<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    use HasFactory;
    protected $keyType = 'integer';

    protected $fillable = ['repo', 'name', 'addr_id', 'rin', 'phon', 'email', 'fax', 'www', 'name', 'description', 'type_id', 'is_active'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function type()
    {
        return $this->hasMany(Type::class, 'id', 'type_id');
    }

    public function addr()
    {
        return $this->hasMany(Addr::class, 'id', 'addr_id');
    }
}
