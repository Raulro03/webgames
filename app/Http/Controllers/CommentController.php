<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        $request->validate([
            'body' => 'required',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id
        ]);

        return back();
    }
}
