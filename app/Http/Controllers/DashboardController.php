<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteOldArchivedPosts;

class DashboardController extends Controller
{
    public function deleteArchivedPosts()
    {
        (new DeleteOldArchivedPosts())->handle();

        return back()->with('status', 'Los posts archivados antiguos han sido eliminados.');
    }
}

