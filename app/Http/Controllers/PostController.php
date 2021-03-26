<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Post;
use App\Profile;
use App\Story;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function index()
    {
        $usersIFollow = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $usersIFollow)->withCount('comments')->with(['user:users.id,username','userProfile:profiles.id,profiles.user_id,image'])->latest()->paginate(5)->toArray();

        if(count($posts['data'])){
            $ids = array_map(fn($item) => $item['id'], $posts['data']);

            $likedByMe = auth()->user()->likePost->whereIn('id', $ids)->toArray();
            $favoritedByMe = auth()->user()->favorites->whereIn('id', $ids)->toArray();

            $likedByMe = array_map(fn($item) => $item['id'], $likedByMe);
            $favoritedByMe = array_map(fn($item) => $item['id'], $favoritedByMe);

            foreach ($posts['data'] as $post => $value) {
                if(in_array($value['id'], $likedByMe)){
                    $posts['data'][$post]['liked'] = 1;
                }
                if(in_array($value['id'], $favoritedByMe)){
                    $posts['data'][$post]['favorited'] = 1;
                }
            }
        }

        $UsersIFollowAndMe = $usersIFollow->toArray();

        array_push($UsersIFollowAndMe, auth()->user()->profile->id);

        $profilesIDoNotFollow = Profile::whereNotIn('id', $UsersIFollowAndMe)->with('user:id,username')->select('id','bio','user_id','image')->limit(5)->get();

        // Paginated profiles that I follow with their username and all their stories in the last 24hours and checking if I already watched it.
        $profilesWithStories = Profile::whereIn('user_id', $usersIFollow)->with('user:id,username')->with('userStories', function($q){
            $q->with('watchedBy', function($subq){$subq->where('user_sees_story.user_id', auth()->user()->id)->select('user_sees_story.user_id');});
            $q->where('stories.created_at','>=',Story::getTime());})->whereHas('userStories', function($q){$q->where('stories.created_at','>=',Story::getTime());
        })->select('id','user_id','image')->paginate()->toArray();

        $user = auth()->user();
        $user->profile = auth()->user()->profile;

        return view('posts\index', compact('posts', 'profilesIDoNotFollow', 'profilesWithStories', 'user'));
    }

    public function create()
    {
        return view('posts\create');
    }

    public function show(Post $post)
    {
        $user = User::findOrFail($post->user_id);
        $profile = Profile::where('user_id', $post->user_id)->firstOrFail();
        $comments = Comment::where('post_id', $post->id)->where('comment_id', '0')->with('user:id,username', 'userProfile:profiles.user_id,profiles.image',)->withCount(['replies', 'likes'])->latest()->paginate(10)->toArray();

        $liked = 0;
        $favorited = 0;
        $follows = 0;
        if(auth()->user()){
            //post
            $liked = auth()->user()->likePost->where('id', $post->id)->count();
            $favorited = auth()->user()->favorites->where('id', $post->id)->count();
            $follows = auth()->user()->following->contains($profile);


            //  comment
            $ids = array_map(fn($item) => $item['id'], $comments['data']);

            $likedByMe = auth()->user()->likeComment->whereIn('id', $ids)->toArray();

            $likedByMe = array_map(fn($item) => $item['id'], $likedByMe);

            foreach ($comments['data'] as $comment => $value) {
                if(in_array($value['id'], $likedByMe)){
                    $comments['data'][$comment]['liked'] = 1;
                }
            }
        }

        $post->favorited = $favorited;
        $post->liked = $liked;
        $post->follows = $follows;

        return view('posts\show', compact('post', 'comments' ,'user', 'profile'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts\edit', compact('post'));
    }

    public function store(StorePost $request)
    {
        $data = $request->validated();

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

        return redirect('/' . auth()->user()->username);
    }

    public function update(UpdatePost $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        auth()->user()->posts->where('id', $post->id)->update($data);

        return redirect('/' . auth()->user()->username);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        auth()->user()->posts->where('id', $post->id)->delete();

        return redirect('/' . auth()->user()->username);
    }
}