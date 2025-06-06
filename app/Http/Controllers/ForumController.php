<?php

namespace App\Http\Controllers;

use App\Events\FirstPostCreatedEvent;
use App\Events\PostCreatedEvent;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\ForumCategory;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;

class ForumController extends Controller
{

    use AuthorizesRequests;

    public function index()
    {
        return view('pages.forum');
    }


    public function showPostsOfCategory($categoryType)
    {

        $categories = ForumCategory::where('category_type', $categoryType)->pluck('id');

        $posts = Post::whereIn('category_id', $categories)
            ->published()
            ->orderByPublished()
            ->paginate(9);

        return view('forum.category', compact('posts'));
    }

    public function show(Post $post)
    {

        return view('forum.show', compact('post'));
    }

    public function create()
    {
        $forumCategories = ForumCategory::all();
        return view('forum.create', ['post' => new Post() ], compact('forumCategories'));
    }

    public function store(StorePostRequest $request){

        $post = auth()->user()->posts()->create(array_merge($request->validated(),
            [
                'user_id' => auth()->id(),
                'status' => 'published',
            ]
        ));

        $this->firstPostCreatedEvent($post);
        event(new PostCreatedEvent(auth()->user()));

        return to_route('forum')
            ->with('status', 'Post creates successfully!');
    }

    public function edit(Post $post){

        $this->authorize('update', $post);

        $forumCategories = ForumCategory::all();

        return view('forum.edit', compact('post'), compact('forumCategories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $post->update($request->validated());

        Artisan::call('post:update-status');

        return to_route('post.show', $post)
            ->with('status', 'Post updates successfully!');
    }

    public function destroy(Post $post){

        $this->authorize('delete', $post);

        $post->delete();

        return to_route('forum')
            ->with('status', 'Post deletes successfully!');
    }

    public function myPosts()
    {
        $posts = auth()->user()->posts()->orderByPublished()->paginate(6);

        return view('forum.my-posts', compact('posts'));
    }

    private function firstPostCreatedEvent(Post $post)
    {
        $user = $post->user;

        if ($user->posts()->count() === 1) {
            event(new FirstPostCreatedEvent($post));
        }
    }
}
