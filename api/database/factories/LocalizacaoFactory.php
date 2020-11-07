<?php

namespace Database\Factories;

use App\Models\Localizacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocalizacaoFactory extends Factory
{
    protected $model = Localizacao::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(3),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
