<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{

    public function show($user)
    { 
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->profile) : false;
        return view('profiles\show', compact('user', 'follows',));
    }

    public function edit($user)
    {
        return view('profiles\edit', ['user' => $user]);
    }

    public function update($user)
    {
        
        $this->authorize('update', $user->profile);
        
        $data = request()->validate([
           'title'=>'', 
           'description'=>'', 
           'url'=>'', 
           'image'=>''
        ]);

        
        /**
         * Change public to s3 for aws hosting
         * 
         * @var string
         */
        
        $driver = 'public';
        
        
        //* If an image is input, save it to storage
        if(request('image')){
            $imagePath = request('image')->store('profile', $driver);
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image'=>$imagePath];
        }

        //* then create profile
        auth()->user()->profile->update(array_merge($data, $imageArray ?? []));
        
        return redirect("/{$user->username}");
    }
}
