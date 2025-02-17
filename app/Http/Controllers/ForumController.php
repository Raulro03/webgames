<?php

namespace App\Http\Controllers;

use App\Events\PostCreatedEvent;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\ForumCategory;
use App\Models\Post;

class ForumController extends Controller
{
    public function index()
    {
        return view('pages.forum');
    }


    public function showPostsOfCategory($categoryType)
    {

        $categories = ForumCategory::where('category_type', $categoryType)->pluck('id');

        $posts = Post::whereIn('category_id', $categories)->latest('published_at')->paginate(9);

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

        auth()->user()->posts()->create($request->validated());

        event(new PostCreatedEvent(auth()->user()));

        return to_route('forum')
            ->with('status', 'Post creates successfully!');
    }

    public function edit(Post $post){

        return view('forum.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $post->update($request->validated());

        return to_route('posts.show', $post)
            ->with('status', 'Post updates successfully!');
    }

    public function destroy(Post $post){
        $post->delete();

        return to_route('forum')
            ->with('status', 'Post deletes successfully!');
    }

    public function myPosts()
    {
        $posts = auth()->user()->posts()->paginate(6);

        return view('forum.my-posts', compact('posts'));
    }
}
