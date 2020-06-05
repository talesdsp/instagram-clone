<?php

namespace App\Http\Controllers;

use \App\User;

use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($user)
    {
        return $user->profile->followers->count();
    }

    public function store($user)
    {
        return auth()->user()->following()->toggle($user->profile);
    }
}
