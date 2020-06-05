<?php

namespace App\Http\Controllers;


use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usersIFollow = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $usersIFollow)->with('user')->latest()->paginate(5);

        return view('posts\index', ['posts'=> $posts]);
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

        return redirect('/', auth()->user()->username);
    }

    public function show(Post $post)
    {
        return view('posts\show', ['post'=> $post]);
    }

}
