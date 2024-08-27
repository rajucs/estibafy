<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHelpers extends Model
{
    use HasFactory;
    public $table = "job_helpsers";
    protected $fillable = array(
        'job_id' ,
        'user_id' ,
        'helper_id' ,
        'status' ,
        'job_comment_status' ,
        'approved_by' ,
    );

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }

    public function helper_profile()
    {
        return $this->hasOne(Helpers::class, 'id', 'helper_id');
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class, 'id', 'job_id');
    }
    public function jobAsset()
    {
        return $this->hasOne(JobAssets::class, 'job_helper_id','helper_id');
    }

}
