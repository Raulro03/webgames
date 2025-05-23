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
        if ($user->hasRole('admin')) {
            $user->syncRoles(['author']);
            return back()->with('status', 'Este usuario ahora es author.');
        } else {
            $user->syncRoles(['admin']);
            return back()->with('status', 'El usuario ahora es administrador.');
        }

    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard')->with('status', 'User deleted successfully.');
    }
}
