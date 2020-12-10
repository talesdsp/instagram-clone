<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', 'edited', 'post_id', 'comment_id'
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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'user_likes_comment')->orderBy('user_likes_comment.created_at', 'DESC');
    }
}
