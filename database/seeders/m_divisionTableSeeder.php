<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\m_division;
class m_divisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        m_division::create([
            'division_code'=>'1',
            'division_name'=>'Teknologi', 
            'parent_division_code'=>'1'                      
        ]);

        m_division::create([
            'division_code'=>'2',
            'division_name'=>'Riset dan Pengembangan', 
            'parent_division_code'=>'2'                      
        ]);

        m_division::create([
            'division_code'=>'3',
            'division_name'=>'Pemasaran', 
            'parent_division_code'=>'3'                      
        ]);
        
    }
}
