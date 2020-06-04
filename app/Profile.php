<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'title', 'description', 'url', 'image'
    ];

    public function profileImage()
    {
        $path = $this->image ? $this->image : "profile/0kw9UuVfyLDeWnAlDwmyvMY9gOqgDz3GbAdaELEI.jpeg";
        return("/storage/{$path}");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
