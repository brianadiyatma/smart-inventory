<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DummyUserUatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'KUSNO', 
            'nip'=> '999900103',
            'email' => 'kusno.99103@inka.co.id',
            'password' => bcrypt('999900103'),
            'division_code'=> '6',
            'position_code'=> '4',
            'plant_code'=> '1'
        ])->assignRole('Operator');

        User::create([
            'name' => 'MISRAN', 
            'nip'=> '999900099',
            'email' => 'misran@inka.co.id',
            'password' => bcrypt('999900099'),
            'division_code'=> '6',
            'position_code'=> '4',
            'plant_code'=> '1'
        ])->assignRole('Operator');

        User::create([
            'name' => 'SIRAN', 
            'nip'=> '999800048',
            'email' => 'siran@inka.co.id',
            'password' => bcrypt('999800048'),
            'division_code'=> '6',
            'position_code'=> '3',
            'plant_code'=> '1'
        ])->assignRole('Manager');

        User::create([
            'name' => 'PAJAR BASUKI', 
            'nip'=> '999800001',
            'email' => 'pajar.basuki@inka.co.id',
            'password' => bcrypt('999800001'),
            'division_code'=> '5',
            'position_code'=> '2',
            'plant_code'=> '1'
        ])->assignRole('Admin');
    }
}
