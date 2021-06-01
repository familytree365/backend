<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $connection = 'landlord';
    
    protected $fillable = ['message', 'sender_id', 'chat_id', 'reply_to'];
    protected $dates = ['created_at', 'updated_at'];
    protected $with = ['sender'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {        
        return $this->belongsTo(User::class, 'sender_id');
    }

}
