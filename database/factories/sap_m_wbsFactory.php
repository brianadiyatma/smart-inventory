<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_m_wbsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $project = \App\Models\sap_m_project::pluck('id')->all();
        return [
            'wbs_code' => $this->faker->unique()->randomNumber(5,true),
            'wbs_desc' => $this->faker->realText(50,2),            
            'project_id' => $this->faker->randomElement($project),
        ];
    }
}
