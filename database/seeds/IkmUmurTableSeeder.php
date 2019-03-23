<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmUmurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql2')->table('ikm_umur')->insert([

        	[
        		'umur' => 'Dibawah 21 Tahun'
        	],
        	[
        		'umur' => '21-30 Tahun'
        	],
        	[
        		'umur' => '31-40 Tahun'
        	],
        	[
        		'umur' => '41-50 Tahun'
        	],
        	[
        		'umur' => 'Diatas 51 Tahun'
        	]

        ]);
    }
}
