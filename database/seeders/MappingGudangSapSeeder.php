<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\sap_m_storage_bin;
use App\Imports\SapMStorage;
use Maatwebsite\Excel\Facades\Excel;

class MappingGudangSapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test = Excel::import(new SapMStorage, public_path('seeder_file/Mapping Gudang SAP.xlsx'));
    }
}
