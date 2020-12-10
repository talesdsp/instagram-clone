<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'bio', 'url', 'image'
    ];

    public function profileImage()
    {
        $path = $this->image ? $this->image : "profile/0kw9UuVfyLDeWnAlDwmyvMY9gOqgDz3GbAdaELEI.jpeg";
        return ("/storage/{$path}");
    }



    public function userStories()
    {
        return $this->hasManyThrough(
            Story::class, // target
            User::class,    // through
            'id',           // Foreign key on through table...
            'user_id',      // Foreign key on target table...
            'user_id',      // Local key on this table...
            'id'            // Local key on through table...
        );
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  PIVOTS
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follows_profile')->orderBy('user_follows_profile.created_at', 'DESC');
    }
}
