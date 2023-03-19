<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_t_bpmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $project = \App\Models\sap_m_project::pluck('project_code')->all();
        $date = $this->faker->dateTimeBetween('-2 year', '+1 week');        
        return [
            'pembuat' => $this->faker->name(),
            'doc_number' => $this->faker->unique()->randomNumber(5,true),
            'doc_date' => $date,
            'status' => $this->faker->randomElement(['PROCESSED','UNPROCESSED','ON PROCESS']),
            'fiscal_year' => $date->format('Y'),
            'started_at' => $date,
            'enter_date' => now(),
        ];
    }
}
