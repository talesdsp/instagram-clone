<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        "story",
    ];

    public static function getTime(){
        //Get the current timestamp.
        $currentTime = time();

        //The number of hours that you want
        //to subtract from the date and time.
        $hoursToSubtract = 24;

        //Convert those hours into seconds so
        //that we can subtract them from our timestamp.
        $timeToSubtract = ($hoursToSubtract * 60 * 60);

        //Subtract the hours from our Unix timestamp.
        $timeInPast = $currentTime - $timeToSubtract;

        //Print it out in a human-readable format.
        return date("Y-m-d H:i:s", $timeInPast);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function watchedBy()
    {
        return $this->belongsToMany(User::class, 'user_sees_story');
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
}
