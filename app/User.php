<?php

namespace App;

use App\Mail\NewUserWelcomeMail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name','email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);

            Mail::to($user->email)->send(new NewUserWelcomeMail());
        });
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }


    // PIVOTS
    public function watchedStories()
    {
        return $this->belongsToMany(Story::class, 'user_sees_story')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'user_favorites_post')->withTimestamps()->orderBy('user_favorites_post.created_at', 'DESC');
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class, 'user_follows_profile')->withTimestamps()->orderBy('user_follows_profile.created_at', 'DESC');
    }

    public function likePost()
    {
        return $this->belongsToMany(Post::class, 'user_likes_post')->withTimestamps();
    }

    public function likeComment()
    {
        return $this->belongsToMany(Comment::class, 'user_likes_comment')->withTimestamps();
    }


}
