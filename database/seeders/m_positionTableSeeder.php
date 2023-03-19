<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\m_position;
class m_positionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        m_position::create([
            'position_code'=>'1',
            'position_name'=>'General Manager',                       
        ]);

        m_position::create([
            'position_code'=>'2',
            'position_name'=>'Senior Manager',                       
        ]);

        m_position::create([
            'position_code'=>'3',
            'position_name'=>'Manager',                       
        ]);

        m_position::create([
            'position_code'=>'4',
            'position_name'=>'Staff',                       
        ]);
    }
}
