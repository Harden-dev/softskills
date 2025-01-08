<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

class Article extends Model
{
    use Sluggable;

    protected $fillable = 
    [
        'title',
        'content',
        'slug', 
        'file_path',  
        'published_at',
        'user_id',
        'category_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }


      // Utiliser le slug pour les routes
      public function getRouteKeyName()
      {
          return 'slug';
      }


      public function scopePublished(Builder $query)
      {
        return $query->where(function($query) {
          $query->whereNull('published_at')  // Articles sans date de publication (publiés immédiatement)
                ->orWhere('published_at', '<=', now());  // OU articles dont la date de publication est passée
      });
      }

      public function scopeScheduled(Builder $query)
      {
        return $query->whereNotNull('published_at')
        ->where('published_at','>', now());
      }
      public function setPublishedAtAttribute($value)
      {
          $this->attributes['published_at'] = Date::parse($value);
      }
  
      public function user()
      {
        return $this->belongsTo(User::class);
      }

      public function category()
      {
        return $this->belongsTo(Categorie::class);
      }

      public function comments():HasMany
      {
        return $this->hasMany(Comment::class);
      }


}
