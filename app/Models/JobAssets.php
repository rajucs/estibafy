<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAssets extends Model
{
    use HasFactory;
    public $table = "job_assets";
    protected $fillable = array(
        'job_helper_id',
        'start_image',
        'end_image',
        'job_start',
        'created_at',
        'updated_at',
        'start_job_latitude',
        'start_job_longitude',
        'stop_job_latitude',
        'stop_job_longitude'
    );
    public function jobHelpers()
    {
        return $this->belongsTo(JobHelpers::class, 'job_helper_id', 'helper_id');
    }
}
