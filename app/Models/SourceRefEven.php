<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $group
 * @property int    $gid
 * @property string $even
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 */
class SourceRefEven extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sourceref_even';
    use HasFactory;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['group', 'gid', 'even', 'role', 'created_at', 'updated_at'];
}
