<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption', 'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userProfile()
    {
        return $this->hasOneThrough(
            Profile::class, // target
            User::class,    // through
            'id',           // Foreign key on through table...
            'user_id',      // Foreign key on target table...
            'user_id',      // Local key on this table...
            'id'            // Local key on through table...
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('comment_id', 0);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'user_favorites_post')->orderBy('user_favorites_post.created_at', 'DESC');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'user_likes_post')->orderBy('user_likes_post.created_at', 'DESC');
    }
}
