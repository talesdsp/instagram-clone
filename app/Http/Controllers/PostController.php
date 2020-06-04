<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts\create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required','image'],
        ]);

        /**
         * Change public to s3 for aws hosting
         * 
         * @var string
         */
         $driver = 'public';

        $imagePath = request('image')->store('uploads', $driver);

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);

        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/', auth()->user()->id);
    }

    public function show(\App\Post $post_id)
    {
        return view('posts\show', ['post'=> $post_id]);
    }

}
