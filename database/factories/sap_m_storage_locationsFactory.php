<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
<<<<<<< HEAD
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
=======
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\sap_m_storage_locations>
>>>>>>> b03e868c9737ea9d6e0702c5b212dddc5e3214f2
 */
class sap_m_storage_locationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'storage_location_code' => $this->faker->unique()->randomNumber(5,true),
            'storage_location_name' => $this->faker->name(),
        ];
    }
}
