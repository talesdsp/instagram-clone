<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StoreComment;
use App\Http\Requests\UpdateComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct(){
        $this->middleware("auth", ['except'=>['index',]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComment $request)
    {
        $data = $request->validated();
        $newComment = auth()->user()->comments()->create($data);

        $comment = Comment::whereId($newComment->id)->withCount('likes')->with(['user:users.id,username','userProfile:profiles.user_id,image'])->first();

        return response()->json(['comment'=> $comment]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {

        $comments = $comment->replies()->withCount('likes')->with('user:id,username','userProfile:user_id,image')->orderBy('created_at')->paginate(3)->toArray();
        $ids = array_map(fn($item) => $item['id'], $comments['data']);


            $likedByMe = auth()->user()->likeComment->whereIn('id', $ids)->toArray();

            $likedByMe = array_map(fn($item) => $item['id'], $likedByMe);

            foreach ($comments['data'] as $comment => $value) {
                if(in_array($value['id'], $likedByMe)){
                    $comments['data'][$comment]['liked'] = 1;
                }
            }


        return response()->json(['comments'=>$comments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComment $request, Comment $comment)
    {
        $data = $request->validated();

        auth()->user()->comments()->update(array_merge($data, ['edited' => true]));
        $comment = $comment->fresh();
        $comment = $comment->with('user:users.id,username', 'userProfile:user_id,image');

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        auth()->user()->comments->where('id', $comment->id)->delete();

        return response()->json(['id'=> $comment->id]);
    }
}
