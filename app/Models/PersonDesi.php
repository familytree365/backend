<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $group
 * @property int    $gid
 * @property string $rela
 * @property string $created_at
 * @property string $updated_at
 */
class PersonDesi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person_desi';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['group', 'gid', 'desi', 'created_at', 'updated_at'];
}
