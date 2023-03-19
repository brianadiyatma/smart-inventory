<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class sap_t_sttp_dtlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sttp = \App\Models\sap_t_sttp::pluck('id')->all();
        $uom = \App\Models\sap_m_uoms::pluck('uom_code')->all();
        $sttp_id = $this->faker->randomElement($sttp);
        $wbs = \App\Models\sap_m_wbs::pluck('wbs_code')->all();
        $material = \App\Models\sap_m_materials::pluck('material_code')->all();
        $material_c = $this->faker->randomElement($material);
        return [            
            'sttp_id' => $sttp_id,
            'wbs_code' => $this->faker->randomElement($wbs),
            'material_code' => $material_c,
            'material_desc' => \App\Models\sap_m_materials::where('material_code',$material_c)->first()->material_desc,
            'line_item' => $this->faker->realText(20),
            'uom' => $this->faker->randomElement($uom),
            'qty_po' => $this->faker->randomNumber(2,true),
            'qty_gr_105' => $this->faker->randomNumber(2,true),
            'qty_ncr' => $this->faker->randomNumber(2,true),
            'qty_warehouse' => $this->faker->randomNumber(2,true),            
        ];
    }
}
