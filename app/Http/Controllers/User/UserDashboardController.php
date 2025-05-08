<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function generateTokens() {

        $email = Auth::user()->email;

        Artisan::call('app:generate-user-token', [
            'email' => $email,
        ]);

        $output = Artisan::output();

        return back()->with('success', "Token generado correctamente. Revisa storage/app/tokens.txt o mira abajo:\n" . $output);
    }
}
