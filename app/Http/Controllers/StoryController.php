<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StoreStory;
use App\Post;
use App\Profile;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function index()
    {
    // todo
    }

    public function create()
    {
        return view('stories\create');
    }

    public function store(Request $request)
    {
        /**
         * Change public to s3 for aws hosting
         *
         * @var string
         */
        $driver = 'public';

        $imagePath = request('story')->store('story', $driver);

        $type = 'video';

        if (strpos(mime_content_type(public_path('storage', $imagePath)), 'image') == true) {
            $type = 'image';
        }

        auth()->user()->stories()->create([
            'story' => $imagePath,
            'type'=> $type
        ]);

        return redirect('/' . auth()->user()->username);
    }

    public function destroy(Story $story)
    {
        $this->authorize('delete', $story);

        auth()->user()->stories->where('id', $story->id)->delete();

        return redirect('/' . auth()->user()->username);
    }
}
