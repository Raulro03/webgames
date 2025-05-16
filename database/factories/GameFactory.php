<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(200),
            'release_date' => Carbon::now()->subYears(rand(0, 10)),
            'average_rating' => $this->faker->randomFloat(2, 0, 9.99),
            'price' => $this->faker->randomNumber(),
            'image_url' => function () {
                // Ruta de origen (donde tienes las imágenes base)
                $sourceDir = public_path('images/games');

                // Imágenes disponibles
                $files = ['ds1.png', 'wars.png', 'uncharted.png'];

                // Escoger una aleatoriamente
                $filename = Arr::random($files);
                $originalPath = $sourceDir . '/' . $filename;

                // Crear nombre único
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $newFilename = Str::random(40) . '.' . $extension;

                // Ruta de destino en el disco 'public'
                $targetPath = 'images/games/' . $newFilename;

                // Copiar imagen al storage/app/public/images/characters
                Storage::disk('public')->put($targetPath, file_get_contents($originalPath));

                // Guardar en la base de datos la ruta accesible públicamente
                return $targetPath;
            },
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
