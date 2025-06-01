<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\ForbiddenWord;
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
            'words' => ForbiddenWord::where('status', 'pending')->get()
        ];

        $pdfPath = 'reports/Resumen_' . Auth::user()->name . '.pdf';
        $pdfReady = \Storage::disk('public')->exists($pdfPath);

        $view = auth()->user()->hasRole('admin') ? 'admin-dashboard' : 'dashboard';

        return view($view, [
            'stats' => $stats,
            'pdfReady' => $pdfReady
        ]);
    }
}

