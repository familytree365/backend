<?php

namespace App\Models;

use App\Models\Provider;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, Billable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'email_verified_at'
    ];
    protected $connection = 'landlord';

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function providers()
    {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }

    public function userChats()
    {     
        return $this->belongsToMany(Chat::class, ChatMember::class, 'user_id', 'chat_id')->withPivot('latest_read_msg'); 
    }

    public function Company()
    {
        return $this->belongsToMany(Company::class, 'user_company');
    }

    public function sendEmailVerificationNotification()
    {
        return $this->notify(new VerifyNotification());
    }

    public function chatFormat(){
        return [
            "_id" => $this->id,
            "username" => $this->userName(),
            "avatar" => '',
            "status" => [
                "state" => 'online',
                //"lastChanged" => '',
            ],
            
        ];
    }

    public function userName(){
        return $this->first_name;
    }

    public function totalUnreadMessages(){
        $count = 0;
        $userChats = $this->userChats;
        foreach($userChats as $chat){
            $latestReadMsgId = $chat->pivot->latest_read_msg;
            $count += $chat->chatMessages()->where('id', '>', $latestReadMsgId)->count();
        }
        return $count;
    }

}
