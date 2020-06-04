<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{

    public function show(User $user)
    { 
        return view('profiles\show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('profiles\edit', ['user' => $user]);
    }

    public function update(User $user)
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
        }

        //* then create profile
        auth()->user()->profile->update(array_merge($data, ['image'=>$imagePath ?? null]));
        return redirect("/{$user->username}");
    }
}
