<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_t_bpm_dtlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $bpm = \App\Models\sap_t_bpm::pluck('id')->all();
        $uom = \App\Models\sap_m_uoms::pluck('uom_code')->all();
        $bpm_id = $this->faker->randomElement($bpm);
        $wbs = \App\Models\sap_m_wbs::pluck('wbs_code')->all();
        $material = \App\Models\sap_m_materials::pluck('material_code')->all();
        $material_c = $this->faker->randomElement($material);
        $plant = \App\Models\sap_m_plant::pluck('plant_code')->all();
        return [            
            'bpm_id' => $bpm_id,
            'reservation_number' => $this->faker->randomNumber(6,true),
            'item' => $this->faker->realText(20),
            'wbs_code' => $this->faker->randomElement($wbs),
            'material_code' => $material_c,
            'plant_code' => $this->faker->randomElement($plant),
            'requirement_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'requirement_qty' => $this->faker->randomNumber(2,true),
            'uom_code' => $this->faker->randomElement($uom),
            'note' => $this->faker->realText(15),            
        ];
    }
}
