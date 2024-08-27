<?php

namespace App\Models;

use App\Helper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'name',
        'email',
        'password',
        'isVerified',
        'payment_days'
    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = array(
        'password',
        'remember_token',
    );

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = array(
        'email_verified_at' => 'datetime',
    );


    /*surname relation*/
    public function user_roles()
    {
        return $this->belongsTo('App\Models\UserRoles', 'user_type');
    }
    public function checkout()
    {
        return $this->hasMany(Checkout::class);
    }

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
    public function company()
    {
        return $this->hasOne(Companies::class, 'user_id', 'id');
    }
    public function companyHelper()
    {
        return $this->hasMany(Helpers::class, 'company_id', 'id');
    }
    public function job()
    {
        return $this->hasOne(Job::class);
    }
}
