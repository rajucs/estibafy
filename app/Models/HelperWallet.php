<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelperWallet extends Model
{
    use HasFactory;
    public $table = "helper_wallet";

      protected $fillable = [
        'checkout_id',
        'helper_id',
        'job_id',
        'total_amount',
        'tax',
        'sub_total',
        'tip_id',
        'hours',
        'release_status',
        'payment_credential_id',
    ];
    public function job()
    {
        return $this->hasOne(Job::class, 'id','job_id');
    }
    public function helperEarningsPay(){
        return $this->hasOne(HelperEarningPayments::class, 'checkout_id', 'checkout_id');
    }
}
