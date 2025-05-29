<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePDFUserHistoryJob;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use App\Models\Platform;
use PDF;

class PDFController extends Controller
{
    public function gamePDF($id)
    {
        $game = Game::findOrFail($id);

        $imagePath = public_path( 'storage/' . $game->image_url);
        $imageData = '';

        if (file_exists($imagePath)) {
            $imageData = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($imagePath));
        }

        $pdf = PDF::loadView('pdf.game', compact('game', 'imageData'));

        return $pdf->download('Juego_' . $game->title . '.pdf');
    }

    public function platformPDF($id)
    {
        $platform = Platform::findOrFail($id);

        $imagePath = public_path('storage/' . $platform->image_url);
        $imageData = '';

        if (file_exists($imagePath)) {
            $imageData = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($imagePath));
        }

        $pdf = PDF::loadView('pdf.platform', compact('platform', 'imageData'));

        return $pdf->download('Plataforma_' . $platform->name . '.pdf');
    }


    public function generateUserPdf()
    {
        $user = auth()->user();
        GeneratePDFUserHistoryJob::dispatch($user);

        return back()->with('status', 'El reporte se está generando. Estará disponible en breve.');
    }
}
