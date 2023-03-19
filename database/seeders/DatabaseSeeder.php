<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\sap_m_project::factory(10)->create();
        // \App\Models\sap_m_wbs::factory(20)->create();

        // \App\Models\sap_m_material_type::factory(5)->create();
        // \App\Models\sap_m_material_groups::factory(5)->create();
        // \App\Models\sap_m_uoms::factory(5)->create();
        // \App\Models\sap_m_materials::factory(20)->create();
        // \App\Models\sap_m_plant::factory(5)->create();

        // \App\Models\sap_m_storage_bin::factory(5)->create();
        // \App\Models\sap_m_storage_locations::factory(10)->create();
        // \App\Models\sap_m_storage_type::factory(5)->create();

        \App\Models\sap_t_sttp::factory(10)->create();
        \App\Models\sap_t_sttp_dtl::factory(30)->create();

        \App\Models\sap_t_bpm::factory(10)->create();
        \App\Models\sap_t_bpm_dtl::factory(30)->create();

        // \App\Models\sap_t_gi::factory(10)->create();
        // \App\Models\sap_t_gi_dtl::factory(50)->create();

        // // $this->seedMasterDatSap();
        // $this->call(m_divisionTableSeeder::class);
        // $this->call(m_positionTableSeeder::class);
        // $this->call(m_plantTableSeeder::class);
        // $this->call(PermissionTableSeeder::class);
        // $this->call(CreateAdminUserSeeder::class);
    }

//     public function seedMasterDatSap(){
//         Artisan::call('sap:get-master-project');
//         Artisan::call('sap:get-master-wbs');
//         Artisan::call('sap:get-master-uom');
//         Artisan::call('sap:get-master-plant');

//         Artisan::call('sap:get-master-storage-loc');

//         Artisan::call('sap:get-master-material-type');
//         Artisan::call('sap:get-master-material-group');
//         Artisan::call('sap:get-master-material');

//         Artisan::call('sap:get-master-storage-type');
//         Artisan::call('sap:get-master-storage-bin');
//     }
}
