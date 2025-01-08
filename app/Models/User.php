<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug', 
        'email',
        'google_id',
        'password',
    ];

    

    // Utiliser le slug pour les routes
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Boot function pour générer automatiquement le slug UUID
     */
    protected static function boot()
    {
        parent::boot();

        // Génère automatiquement le slug avant la création
        static::creating(function ($model) {
            // Option 1: UUID complet
            $model->slug = Str::uuid(); // Résultat: 123e4567-e89b-12d3-a456-426614174000
        });
    }

    public function articles():HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
