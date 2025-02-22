<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TrashPostsController extends Controller
{
    use AuthorizesRequests;

    public function showTrashPosts()
    {
        $posts = auth()->user()->posts()->onlyTrashed()->orderByPublished()->paginate(6);

        return view('forum.trash-posts', compact('posts'));
    }

    public function restorePost($postId)
    {
        $post = Post::onlyTrashed()->findOrFail($postId);

        $this->authorize('restore', $post);

        $post->restore();

        return to_route('forum')
            ->with('status', 'Post restores successfully!');
    }

    public function forceDeletePost($postId)
    {
        $post = Post::onlyTrashed()->findOrFail($postId);

        $this->authorize('forceDelete', $post);

        $post->forceDelete();

        return to_route('forum')
            ->with('status', 'Post deletes permanently!');
    }

}
