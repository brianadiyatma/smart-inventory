<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_m_material_typeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'material_type_code' => $this->faker->unique()->randomNumber(5,true),
            'material_type_desc' => $this->faker->realText(60,2),
        ];
    }
}
