<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Bagas Shop',
            'alamat' => 'Jl. Raya Indah',
            'telepon' => '081234779987',
            'tipe_nota' => 1, // kecil
            'path_logo' => '/img/logo.png',
        ]);
    }
}
