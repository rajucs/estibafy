<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMehodCred extends Model
{
    use HasFactory;
    public $table = "payment_credentials";

    protected $fillable = array(
        'stackholder_id' ,
        'stackholder_type' ,
        'payment_method_id' ,
        'name' ,
        'card_no' ,
        'expiry_date',
        'cvv'
    );
}
