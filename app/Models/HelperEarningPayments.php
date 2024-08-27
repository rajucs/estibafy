<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelperEarningPayments extends Model
{
    use HasFactory;
    public $table = "helper_earning_payments";

    protected $fillable = [
        'job_id',
        'checkout_id',
        'helper_id',
        'total_amount',
    ];
    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'job_id');
    }
    public function helperWallet(){
        return $this->hasOne(HelperWallet::class, 'checkout_id', 'checkout_id');
    }
}
