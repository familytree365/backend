<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $group
 * @property int    $gid
 * @property string $name
 * @property int    $addr_id
 * @property string $rin
 * @property string $rfn
 * @property string $lang
 * @property string $phon
 * @property string $email
 * @property string $fax
 * @property string $www
 * @property string $created_at
 * @property string $updated_at
 */
class Subm extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    use HasFactory;
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['group', 'gid', 'name', 'addr_id', 'rin', 'rfn', 'lang', 'phon', 'email', 'fax', 'www', 'created_at', 'updated_at'];

    public function addr()
    {
        return $this->belongsTo(Addr::class);
    }
}
