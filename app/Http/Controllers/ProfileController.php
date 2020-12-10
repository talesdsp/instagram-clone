<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Post;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;


class ProfileController extends Controller
{

    public function show(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->profile) : false;

        $postCount = Cache::remember('count.posts.' . $user->id, now()->addSeconds(60), function () use ($user) {
            return $user->posts->count();
        });

        $followersCount = Cache::remember('count.followers.' . $user->id, now()->addSeconds(120), function () use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember('count.following.' . $user->id, now()->addSeconds(120), function () use ($user) {
            return $user->following->count();
        });

        $user->profile = $user->profile;

        $stories = Story::where([['user_id','=', $user->id],['created_at','>=', Story::getTime()]])->with(['user:users.id,username','userProfile:profiles.id,profiles.user_id,image'])->with('watchedBy', function($q){
            $q->where('user_sees_story.user_id', auth()->user()->id)->select('user_sees_story.user_id');
        })->get()->toArray();

        $posts = Post::where("user_id", $user->id)->latest()->get();

        return view('profiles\show', compact('posts','user', 'follows', 'postCount', 'followersCount', 'followingCount', 'stories'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles\edit', ['user' => $user]);
    }

    public function update(UpdateProfile $request, User $user)
    {
        $this->authorize('update', $user->profile);

        $data = $request->validated();

        /**
         * Change public to s3 for aws hosting
         *
         * @var string
         */

        $driver = 'public';


        //* If an image is input, save it to storage
        if (request('image')) {
            $imagePath = request('image')->store('profile', $driver);
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        //* then create profile
        auth()->user()->profile->update(array_merge($data, $imageArray ?? []));

        return redirect("/{$user->username}");
    }
}
