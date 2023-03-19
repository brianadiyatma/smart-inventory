<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin'])->givePermissionTo('Admin');
        Role::create(['name' => 'Operator'])->givePermissionTo('Operator');
        Role::create(['name' => 'Manager'])->givePermissionTo('Manager');

        User::create([
            'name' => 'Hardi Gimang', 
            'nip'=> '435678123',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1'),
            'division_code'=> '1',
            'position_code'=> '1',
            'plant_code'=> '1'
        ])->assignRole('Admin');    
        
        User::create([
            'name' => 'Ipeh', 
            'nip'=> '123312',
            'email' => 'Ipeh@gmail.com',
            'password' => bcrypt('1'),
            'division_code'=> '1',
            'position_code'=> '1',
            'plant_code'=> '1'
        ])->assignRole('Operator');


        User::create([
            'name' => 'Hepi', 
            'nip'=> '321132',
            'email' => 'Hepi@gmail.com',
            'password' => bcrypt('1'),
            'division_code'=> '1',
            'position_code'=> '1',
            'plant_code'=> '1'
        ])->assignRole('Manager');


      
    }
}
