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

    public function users()
    {        
        return $this->belongsToMany(User::class, ChatMember::class, 'chat_id', 'user_id');  
    }

    public function getChatsByUser($userId){
        $chats = $this->whereHas('users', function ($query) use($userId){            
            $query->where('user_id', $userId);
        })->get();
        //return $chats[0]->users;
        foreach($chats as $chat){
            if($chat->chat_type == 'private'){
                $chat->withUser = $chat->users[0]->pivot->user_id == $userId ? User::find($chat->users[1]->pivot->user_id) : User::find($chat->users[0]->pivot->user_id);
            }

            $chat->chatLabel = $chat->chat_type == 'private' ? $chat->withUser->first_name : $chat->chat_name;
            
            $chat->lastMessage = $chat->lastMessage();
            $chat->is_member = $chat->isMember($userId);
            $chatUsers = [];
            //$chat->users = [];
            foreach($chat->users as $chatUser){
                $chatUsers[] = $chatUser->chatFormat();
            }
            $chat->formattedUsers = $chatUsers;
        }
        return $chats;
    }

    public function lastMessage()
    {
        $formattedMessage = null;
        $lastMessage = $this->chatMessages()->orderBy('created_at', 'DESC')->first();
        if($lastMessage ){
            $formattedMessage  = [
                "content" => $lastMessage->message,
                "senderId" => $lastMessage->sender_id,
                "username" => $lastMessage->sender->first_name,
                "timestamp" => $lastMessage->created_at,
                "saved" => true,
                "distributed" => true,
                "seen" => true,
                "new" => false                
            ];
        }
        return $formattedMessage;
    }

    public function isMember($userId)
    {
        return $this->users->contains($userId);
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
