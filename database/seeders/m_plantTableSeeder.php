<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\sap_m_plant;
class m_plantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        sap_m_plant::create([
            'plant_code'=>'1',
            'plant_name'=>'INKA',                       
        ]);
    }
}
