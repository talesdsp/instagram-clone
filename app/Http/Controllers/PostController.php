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
        return view('posts.create');
    }

    public function store(Request $request)
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

        $image = Image::make(\public_path("storage/{$imagePath}"))->fit(1200, 1200);

        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/', auth()->user()->id);
    }

}
