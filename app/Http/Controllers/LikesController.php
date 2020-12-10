<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getComments(Comment $comment)
    {
        return auth()->user()->likeComment->where('comment_id', $comment->id);
    }

    public function comment(Comment $comment)
    {
        return auth()->user()->likeComment()->toggle($comment);
    }

    public function getPosts(Post $post)
    {
        return auth()->user()->likePost->where('post_id', $post->id);
    }

    public function post(Post $post)
    {
        return auth()->user()->likePost()->toggle($post);
    }
}
