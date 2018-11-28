<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterPegawaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_pegawai')->insert([

            [
                'nama' => 'Superadmin',
                'nip' => NULL,
                'jenis_karantina' => NULL,
                'golongan_id' => NULL,
                'jabatan_id' => NULL,
                'wilker_id' => 1,
                'is_active' => 1
            ],
            [
                'nama' => 'Administrator',
                'nip' => NULL,
                'jenis_karantina' => NULL,
                'golongan_id' => NULL,
                'jabatan_id' => NULL,
                'wilker_id' => 1,
                'is_active' => 1
            ],
            
        ]);
    }
}
