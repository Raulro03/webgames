<?php

namespace App\Http\Controllers;

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

    public function showPost(Post $post)
    {


        return view('forum.show', compact('post'));
    }

    public function storePost(StorePostRequest $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('forum.index');
    }
}
