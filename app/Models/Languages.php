<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;
    public $table = "languages";
    protected $fillable = array(
        'field_name',
        'lang',
        'translation',
    );
}
