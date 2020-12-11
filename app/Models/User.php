<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Provider;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable {

    use HasFactory,
        Notifiable,
        HasApiTokens;

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
    ];
    protected $connection = 'landlord';

    public function sendPasswordResetNotification($token) {
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

    public function providers() {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }

    public function userStartedChats() {
        return $this->hasMany('App\Chat', 'user_1');
    }

    public function userNotStartedChats() {
        return $this->hasMany('App\Chat', 'user_2');
    }

    public function userChats() {
        return $this->userStartedChats->merge($this->userNotStartedChats);
    }

}
