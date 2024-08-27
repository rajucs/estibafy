<?php

namespace App\Models;

use App\Models\Job as jobs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as users;

class Checkout extends Model
{
    protected $table = 'checkout';
    protected $fillable = array(
        'job_id',
        'total',
        'tax',
        'tax_rate',
        'sub_total',
        'user_id',
        'base_fare',
        'voice_file',
        'status',
        'days',
        'total_helpers',
        'payement_method',
        'payment_status',
        'payment_days',
        'company_id'
    );

    public function job()
    {
        return $this->belongsTo(Jobs::class);
    }
    public function user()
    {
        return $this->belongsTo(users::class);
    }
}
