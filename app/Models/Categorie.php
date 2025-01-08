<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    //
    use Sluggable;

    protected $fillable = 
    [
        'name',
        'slug'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }

    // Utiliser le slug pour les routes
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function articles():HasMany
    {
        return $this->hasMany(Article::class);
    }

}
