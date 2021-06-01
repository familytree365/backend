<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $connection = 'landlord';

    protected $fillable = ['chat_name', 'chat_type'];
    protected $dates = ['created_at', 'updated_at'];
    protected $with = ['chatMessages'];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function chatMembers()
    {        
        return $this->belongsToMany(User::class, ChatMember::class, 'chat_id', 'user_id');  
    }

    public function getChatsByUser($userId){
        $chats = $this->whereHas('chatMembers', function ($query) use($userId){            
            $query->where('user_id', $userId);
        })->with('chatMembers')->get();
        //return $chats[0]->chatMembers[1];
        foreach($chats as $chat){
            if($chat->chat_type == 'private'){
                $chat->withUser = $chat->chatMembers[0]->pivot->user_id == $userId ? User::find($chat->chatMembers[1]->pivot->user_id) : User::find($chat->chatMembers[0]->pivot->user_id);
            }

            $chat->chatLabel = $chat->chat_type == 'private' ? $chat->withUser->first_name : $chat->chat_name;
            
            $chat->lastMessage = $chat->lastMessage();
            $chat->is_member = $chat->isMember($userId);
        }
        return $chats;
    }

    public function lastMessage()
    {
        return $this->chatMessages()->orderBy('created_at', 'DESC')->first();
    }

    public function isMember($userId)
    {
        return $this->chatMembers->contains($userId);
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
