<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['chat_name', 'chat_type'];
    protected $dates = ['created_at', 'updated_at'];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function chatMembers()
    {
        $chatModelObject = new Chat();    
        return $this->belongsToMany(User::class, $chatModelObject->getConnection()->getDatabaseName().'.chat_members', 'chat_id', 'user_id');
    }

    public function lastMessage()
    {
        return $this->chatMessages()->orderBy('created_at', 'DESC')->firrst();
    }

    // public function firstUser()
    // {
    //     return $this->belongsTo(User::class, 'user_1');
    // }

    // public function secondUser()
    // {
    //     return $this->belongsTo(User::class, 'user_2');
    // }
}
