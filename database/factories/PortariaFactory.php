<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PortariaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numeroPortaria' => rand(),
            'dataCriacao' => fake()->date(),
            'dataEncerramento' => fake()->date(),
            'descricao' => Str::random(100),
            'isPrivate' => rand(0, 1),
        ];
    }
}
