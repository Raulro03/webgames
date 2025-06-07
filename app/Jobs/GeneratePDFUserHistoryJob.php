<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PDF;

class GeneratePDFUserHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        $user = $this->user->loadCount(['posts', 'comments']);
        $posts = $user->posts()->with('forum_category')->get();

        $categoriesCount = collect($posts)->groupBy(fn($post) => $post->forum_category->category_type ?? 'General')
            ->map(fn($group) => count($group));

        $labels = $categoriesCount->keys()->toArray();
        $data = $categoriesCount->values()->toArray();

        $chartImage = null;

        try {
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
            } else {

                $chartImage = null;
            }
        } catch (\Exception $e) {
            \Log::error('Error al obtener gráfico para PDF: ' . $e->getMessage());
        }

        $message = $chartImage === null
            ? 'Por favor, conéctese a Internet para ver el gráfico en el reporte.'
            : null;

        $pdf = Pdf::loadView('pdf.user_report', [
            'user' => $user,
            'categoriesCount' => $categoriesCount,
            'chartImage' => $chartImage,
            'message' => $message,
        ]);

        $filename = 'Resumen_' . $user->name . '.pdf';
        Storage::disk('public')->put("reports/{$filename}", $pdf->output());
    }

    public function getUser()
    {
        return $this->user;
    }
}
