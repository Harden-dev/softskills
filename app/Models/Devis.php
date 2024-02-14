<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nature_client',
        'type_service',
        'budget',
        'nom_client',
        'num_tel',
        'email',
        'description'
    ];
}
