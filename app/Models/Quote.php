<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    //
    protected $fillable =
    [
        'name',
        'tel',
        'email',
        'personality',
        'dev',  
        'budget',
        'description'
    ];
}
