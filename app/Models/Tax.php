<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    public $table = 'tax';
    protected $fillable = [
        'tax_percentage',
    ];
    
    public $timestamps = false;

}
