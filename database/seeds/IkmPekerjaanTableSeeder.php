<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmPekerjaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql2')->table('ikm_pekerjaan')->insert([

        	['pekerjaan' => 'PNS/TNI/POLRI'],
        	['pekerjaan' => 'Pegawai Swasta'],
        	['pekerjaan' => 'Wiraswasta/usahawan'],
        	['pekerjaan' => 'Pelajar/mahasiswa'],
        	['pekerjaan' => 'Lainnya']
        	
        ]);
    
    }
}
