<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHelperGeoData extends Model
{
    use HasFactory;
    public $table = "job_helper_locations";
    protected $fillable = array(
        'job_id',
        'helpers_id',
        'latitude',
        'longitude',
    );
    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }
    public function helper_profile()
    {
        return $this->hasOne(Helpers::class, 'id', 'helpers_id');
    }
}
