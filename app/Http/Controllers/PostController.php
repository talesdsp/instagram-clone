<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        request('image')->store('uploads', $driver);

        auth()->user()->posts()->create($data);

    }

}
