<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users-index', compact('users'));
    }

    public function makeAdmin(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('status', 'Este usuario ya es administrador.');
        }

        $user->syncRoles(['admin']);

        return back()->with('status', 'El usuario ahora es administrador.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard')->with('status', 'User deleted successfully.');
    }
}
