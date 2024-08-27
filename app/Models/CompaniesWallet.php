<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaniesWallet extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'checkout_id',
        'job_id',
        'total_amount',
        'sub_total',
        'tax_amount',
        'release_status'
    ];
    public function company()
    {
        $this->belongsTo(Companies::class);
    }

    public function job()
    {
        return $this->belongsTo(Jobs::class);
    }
}
