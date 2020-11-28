<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $gid
 * @property string $group
 * @property string $obje_id
 * @property string $titl
 * @property string $rin
 * @property string $created_at
 * @property string $updated_at
 */
class MediaObject extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['gid', 'group', 'titl', 'obje_id', 'rin', 'created_at', 'updated_at'];
}
