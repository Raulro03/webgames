<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name(),
            'description' => $this->faker->text(100),
            'age' => $this->faker->numberBetween(1, 100),
            'image_url' => function () {
                // Ruta de origen (donde tienes las imágenes base)
                $sourceDir = public_path('images/characters');

                // Imágenes disponibles
                $files = ['darth.png', 'leon.png', 'mario.png'];

                // Escoger una aleatoriamente
                $filename = Arr::random($files);
                $originalPath = $sourceDir . '/' . $filename;

                // Crear nombre único
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $newFilename = Str::random(40) . '.' . $extension;

                // Ruta de destino en el disco 'public'
                $targetPath = 'images/characters/' . $newFilename;

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
