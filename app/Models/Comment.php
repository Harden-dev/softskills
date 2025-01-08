<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    //
    protected $fillable = [
        'content',
        'user_id',
        'article_id',
        'parent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function replies():HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
