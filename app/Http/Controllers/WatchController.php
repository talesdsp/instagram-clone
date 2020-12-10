<?php

namespace App\Http\Controllers;

use App\Story;
use Illuminate\Http\Request;

class WatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getStory(Story $story)
    {
        return auth()->user()->watchedStories->where('story_id', $story->id);
    }

    public function story(Story $story)
    {
        auth()->user()->watchedStories()->detach($story->id);

        return auth()->user()->watchedStories()->attach($story->id);
    }
}
