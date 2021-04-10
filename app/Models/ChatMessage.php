<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'sender_id', 'chat_id', 'reply_to'];
    protected $dates = ['created_at', 'updated_at'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
