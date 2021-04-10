<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'content', 'author'];
    protected $dates = ['created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany(ForumPostComment::class, 'post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
