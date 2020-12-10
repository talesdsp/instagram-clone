<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites =  auth()->user()->favorites;
        $count = $favorites->count();

        $this->view('', compact('count', 'favorites'));
    }

    public function store(Post $post)
    {
        return auth()->user()->favorites()->toggle($post);
    }
}
