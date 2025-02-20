<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use PDF;

class PDFController extends Controller
{
    public function gamePDF($id)
    {
        $game = Game::findOrFail($id);


        $pdf = PDF::loadView('pdf.game', compact('game'));

        return $pdf->download('Juego_' . $game->title . '.pdf');
    }

    public function platformPDF($id)
    {
        $platform = Platform::findOrFail($id);

        $pdf = PDF::loadView('pdf.platform', compact('platform'));

        return $pdf->download('Plataforma_' . $platform->name . '.pdf');
    }
}
