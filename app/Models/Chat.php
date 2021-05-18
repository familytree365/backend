<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['user_1', 'user_2'];
    protected $dates = ['created_at', 'updated_at'];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function lastMessage()
    {
        return $this->chatMessages()->orderBy('created_at', 'DESC')->firrst();
    }

    public function firstUser()
    {
        return $this->belongsTo(User::class, 'user_1');
    }

    public function secondUser()
    {
        return $this->belongsTo(User::class, 'user_2');
    }
}
