<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);
        $profile = $user->profile;
        $posts = $user->posts;

        return view('profiles.index', ['user' => $user, 'profile' => $profile, 'posts' => $posts]);
    }
}
