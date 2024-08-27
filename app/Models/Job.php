<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $fillable = array(
        'container_id',
        'package_type',
        'start_time',
        'end_time',
        'address',
        'user_id',
        'image_file',
        'voice_file',
        'name',
        'longitude',
        'latitude'
    );
    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }
    public function job_helpers()
    {
        return $this->hasMany(JobHelpers::class, 'job_id', 'id');
    }
    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function companyWallet()
    {
        return $this->hasOne(CompaniesWallet::class);
    }
}
