<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CommentController extends Controller
{

    use AuthorizesRequests;

    public function create(Post $post, ?Comment $comment = null)
    {
        $parent_comment = $comment;

        return view('comment.create', ['comment' => new Comment()], compact('post', 'parent_comment'));
    }

    public function store(StoreCommentRequest $request)
    {
        auth()->user()->comments()->create(array_merge($request->validated(),
            [
                'user_id' => auth()->id(),
                'published_at' => now(),
            ]
        ));

        return to_route('post.show', $request->post_id)
            ->with('status', 'Comment creates successfully!');
    }

    public function edit(Post $post, Comment $comment)
    {
        //$this->authorize('update', $comment);
        $parent_comment = $comment->parent;

        return view('comment.edit', compact('comment','parent_comment', 'post'));
    }

    public function update(UpdateCommentRequest $request, $post, Comment $comment)
    {
        //$this->authorize('update', $comment);
        $comment->update($request->validated());

        return to_route('post.show', $post)
            ->with('status', 'Comment edited successfully!');
    }

    public function destroy(Post $post, Comment $comment)
    {
        //$this->authorize('delete', $comment);

        $comment->delete();

        return to_route('post.show', $post)
            ->with('status', 'Comment deletes successfully!');
    }

    public function myComments()
    {
        $comments = auth()->user()->comments()->with('post')->latest()->paginate(6);
        return view('comment.my-comments', compact('comments'));
    }
}
