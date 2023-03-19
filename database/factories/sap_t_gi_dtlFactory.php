<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_t_gi_dtlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gi = \App\Models\sap_t_gi::pluck('id')->all();
        $uom = \App\Models\sap_m_uoms::pluck('uom_code')->all();
        $gi_id = $this->faker->randomElement($gi);
        $wbs = \App\Models\sap_m_wbs::pluck('wbs_code')->all();
        $material = \App\Models\sap_m_materials::pluck('material_code')->all();
        $storloc = \App\Models\sap_m_storage_locations::pluck('storage_location_code')->all();
        $storloc_code = $this->faker->randomElement($storloc);
        $material_c = $this->faker->randomElement($material);
        return [            
            'gi_id' => $gi_id,
            'material_code' => $material_c,
            'material_desc' => \App\Models\sap_m_materials::where('material_code',$material_c)->first()->material_desc,            
            'qty_order' => $this->faker->randomNumber(2,true),
            'qty_serve' => $this->faker->randomNumber(2,true),
            'storloc_code' => $storloc_code,
            'note' => $this->faker->realText(15),
        ];
    }
}
