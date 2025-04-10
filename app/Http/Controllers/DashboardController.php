<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $stats = [
            'totalPosts' => Post::count(),
            'totalComments' => Comment::count(),
            'totalUsers' => User::count(),
            'userPosts' => Post::where('user_id', Auth::id())->count(),
        ];

            if (auth()->user()->hasRole('admin')) {

                return view('admin-dashboard', ['stats' => $stats]);
            }

            return view('dashboard', ['stats' => $stats]);
    }
}

