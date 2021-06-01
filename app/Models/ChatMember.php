<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMember extends Model
{
    use HasFactory;

    protected $connection = 'landlord';

    protected $with = ['user'];

    protected $fillable = ['user_id', 'chat_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {        
        return $this->belongsTo(User::class);
    }

    
}
