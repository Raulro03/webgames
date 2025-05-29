<?php

namespace App\Http\Controllers;

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
        $user->loadCount(['posts', 'comments']);

        $posts = $user->posts()->with('forum_category')->get();

        $categoriesCount = $posts->groupBy(fn($post) => $post->forum_category->category_type ?? 'General')
            ->map->count();

        $labels = $categoriesCount->keys()->toArray();
        $data = $categoriesCount->values()->toArray();

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => ['#6366f1', '#8b5cf6', '#ec4899', '#10b981']
                ]]
            ]
        ];

        $response = Http::get('https://quickchart.io/chart', [
            'c' => json_encode($chartConfig),
            'format' => 'png',
            'width' => 500,
            'height' => 300,
            'backgroundColor' => 'white',
        ]);

        if ($response->successful()) {
            $chartImage = 'data:image/png;base64,' . base64_encode($response->body());

            $pdf = PDF::loadView('pdf.user_report', compact('user', 'categoriesCount', 'chartImage'));
            return $pdf->download('Resumen_' . $user->name . '.pdf');
        } else {
            return back()->with('error', 'No se pudo generar el gráfico.');
        }
    }
}
