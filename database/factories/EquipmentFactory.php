<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => fake()->numberBetween(1712,22222),
            'type_id' => fake()->numberBetween(0,4),
            'serial_num' => fake()->unique()->word . mt_rand(1, 100),
            'desc' => fake()->realText(230)
        ];
    }
}
