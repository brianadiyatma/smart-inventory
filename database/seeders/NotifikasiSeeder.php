<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 45; $i++) { 
            DB::table('notifikasi')->insert([
                'title' => "Transaksi Baru",
                'body' => "Hallo ada transaksi",                
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
            DB::table('user_notifikasi')->insert([
                'user_id' => 1,
                'notifikasi_id' => $i,
                'status' => 'Belum',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
    }
}
