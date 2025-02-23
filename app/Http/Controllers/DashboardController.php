<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteOldArchivedPosts;
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
    public function deleteArchivedPosts()
    {
        (new DeleteOldArchivedPosts())->handle();

        return back()->with('status', 'Los posts archivados antiguos han sido eliminados.');
    }
}

