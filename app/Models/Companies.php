<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = array(
        'title',
        'web',
        'description',
        'user_id',
        'status',
        'company_mobile',
        'company_address',
        'helper_rate',
        'created_by',
    );
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function companyWallet()
    {
        return $this->hasMany(CompaniesWallet::class, 'company_id', 'user_id');
    }
}
