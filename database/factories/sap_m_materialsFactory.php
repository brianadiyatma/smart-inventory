<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_m_materialsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $uoms = \App\Models\sap_m_uoms::pluck('id')->all();
        $type = \App\Models\sap_m_material_type::pluck('id')->all();
        $group = \App\Models\sap_m_material_groups::pluck('id')->all();
        return [
            'material_code' => $this->faker->unique()->randomNumber(5,true),
            'material_desc' => $this->faker->realText(50,2),            
            'specification' => $this->faker->realText(100,3),            
            'uom_id' => $this->faker->randomElement($uoms), 
            'material_group_id' => $this->faker->randomElement($group), 
            'material_type_id' => $this->faker->randomElement($type), 
        ];
    }
}
