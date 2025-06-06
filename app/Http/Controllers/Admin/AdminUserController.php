<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.users-index', compact('users'));
    }

    public function makeAdmin(User $user)
    {
        $user->syncRoles(['admin']);
        return back()->with('status', 'El usuario ahora es administrador.');
    }

    public function makeModerator(User $user)
    {
        $user->syncRoles(['moderator']);
        return back()->with('status', 'El usuario ahora es moderador.');
    }

    public function removeRole(User $user)
    {
        if ($user->hasAnyRole(['author', 'moderator'])) {
            $user->syncRoles([]);
            return back()->with('status', 'Rol eliminado correctamente.');
        }

        return back()->with('status', 'Este usuario no tiene un rol removable.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard')->with('status', 'User deleted successfully.');
    }
}
