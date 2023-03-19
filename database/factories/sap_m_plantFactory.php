<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\sap_m_plant>
 */
class sap_m_plantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'plant_code' => $this->faker->unique()->randomNumber(5,true),
            'plant_name' => $this->faker->name(),
        ];
    }
}
