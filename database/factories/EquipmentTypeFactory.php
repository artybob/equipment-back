<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentType>
 */
class EquipmentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => fake()->randomElement(['TP-Link TL-WR74', 'D-Link DIR-300', 'D-Link DIR-300 S']),
            'mask_sn' => fake()->randomElement(['XXAAAAAXAA', 'NXXAAXZXaa', 'NXXAAXZXXX']),
        ];
    }
}
