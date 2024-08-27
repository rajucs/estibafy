<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Helpers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $table = "helpers";
    protected $appends = ['imagePath'];
    protected $fillable = array(
        'name',
        'email',
        'password',
        'company_id',
    );

    protected $hidden = array(
        'password',
        'remember_token',
    );
    public function getImagePathAttribute()
    {
        if (isset($this->attributes['image'])) {
            return url('/') . '/helpers/' . $this->attributes['image'];
        }
    }

    public function Completed()
    {
        return $this->hasMany(JobHelpers::class, 'helper_id', 'id')->where('status', 'completed');
    }

    public function Inprocess()
    {
        return $this->hasMany(JobHelpers::class, 'helper_id', 'id')->where('status', 'inprocess');
    }
    public function Inprogress()
    {
        return $this->hasMany(JobHelpers::class, 'helper_id', 'id')->where('status', 'started');
    }
    public function Declined()
    {
        return $this->hasMany(JobHelpers::class, 'helper_id', 'id')->where('status', 'cancelled');
    }
    public function Accepted()
    {
        return $this->hasMany(JobHelpers::class, 'helper_id', 'id')->where('status', 'accepted');
    }
    public function jobs()
    {
        return $this->hasMany(JobHelpers::class, 'helper_id', 'id');
    }
    public function earning()
    {
        return $this->hasMany(HelperWallet::class, 'helper_id', 'id');
    }

    public function helperjobcheckout()
    {
        return $this->hasMany(Checkout::class, 'helper_id', 'job_id');
    }
    public function jobAsset()
    {
        return $this->hasOne(JobAssets::class, 'job_helper_id', 'id');
    }
    public function helpersCompany()
    {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
