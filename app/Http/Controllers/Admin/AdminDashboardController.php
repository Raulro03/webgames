<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\CleanTrashedPosts;
use App\Jobs\DeleteOldArchivedPosts;

class AdminDashboardController extends Controller
{
    public function deleteArchivedPosts()
    {
        DeleteOldArchivedPosts::dispatch();

        return back()->with('status', 'Los posts archivados antiguos han sido eliminados.');
    }

    public function cleanTrashPosts()
    {
        CleanTrashedPosts::dispatch();

        return back()->with('status', 'Los posts en la papelera han sido eliminados.');
    }
}
