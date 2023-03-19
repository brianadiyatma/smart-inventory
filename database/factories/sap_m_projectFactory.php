<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_m_projectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_code' => $this->faker->unique()->randomNumber(5,true),
            'project_desc' => $this->faker->realText(50,2),
            'start_date' =>  now(),
            'end_date' => now(),            
        ];
    }
}
