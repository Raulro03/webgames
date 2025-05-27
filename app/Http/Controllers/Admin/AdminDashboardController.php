<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\CleanTrashedPosts;
use App\Jobs\DeleteOldArchivedPosts;
use App\Models\ForbiddenWord;
use Illuminate\Http\Request;

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

    public function manageForbiddenWord(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:accept,decline',
        ]);

        $word = ForbiddenWord::findOrFail($id);

        $newStatus = $request->action === 'accept' ? 'accept' : 'decline';

        $word->status = $newStatus;
        $word->save();

        return back()->with('status', "Palabra {$newStatus} correctamente.");
    }

}
