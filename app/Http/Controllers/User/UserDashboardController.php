<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreForbiddenWordRequest;
use App\Models\ForbiddenWord;
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

    public function requestForbiddenWord(StoreForbiddenWordRequest $request)
    {
        $request->validated();

        $isAdmin = Auth::user()->hasRole('admin');

        ForbiddenWord::create([
            'word' => $request->word,
            'status' => $isAdmin ? 'accept' : 'pending',
        ]);

        return back()->with('status', $isAdmin
            ? 'Palabra añadida directamente a la lista prohibida.'
            : 'Palabra enviada a los administradores para su revisión.');
    }
}
