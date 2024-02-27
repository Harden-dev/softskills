<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'id',
        'nature_client',
        'type_service',
        'budget',
        'nom_client',
        'num_tel',
        'email',
        'description'
    ];

    public $incrementing=false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
}
