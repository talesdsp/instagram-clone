<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class ProfileController extends Controller
{

    public function show($user)
    { 
        $user = User::whereUsername($user)->firstOrFail();
        return view('profiles\show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('profiles\edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $data = $request()->validate([
           'title'=>'required', 
           'description'=>'', 
           'url'=>'url', 
           'image'=>'image'
        ]);
            $auth->user()->profile->update($data);
        return redirect("/{{$user->id}}");
    }

}
