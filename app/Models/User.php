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

    public function userStartedChats()
    {
        return $this->hasMany(Chat::class, 'user_1')->join('users as partner', 'user_2', '=', 'partner.id');
    }

    public function userNotStartedChats()
    {
        return $this->hasMany(Chat::class, 'user_2')->join('users as partner', 'user_1', '=', 'partner.id');
    }

    public function userChats()
    {
        return $this->userStartedChats->merge($this->userNotStartedChats);
    }

    public function Company()
    {
        return $this->belongsToMany(Company::class, 'user_company');
    }

    public function sendEmailVerificationNotification()
    {
        return $this->notify(new VerifyNotification());
    }
}
