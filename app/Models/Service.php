<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'id',
        'nom_prenom',
        'email',
        'contact',
        'type_services'
    ];

    public $incrementing=false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
}
