<?php

namespace Database\Factories;

use App\Models\Favorito;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FavoritoFactory extends Factory
{
    protected $model = Favorito::class;

    public function definition()
    {
        return [
			'titulo' => $this->faker->name,
			'tema' => $this->faker->name,
			'url' => $this->faker->name,
        ];
    }
}
