<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaObjectFile extends Model
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media_objects_file';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['gid', 'group', 'form', 'medi', 'type', 'created_at', 'updated_at'];
}
