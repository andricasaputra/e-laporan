<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmLayananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ikm_layanan')->insert([

        	['jenis_layanan' => 'Karantina Hewan'],
        	['jenis_layanan' => 'Karantina Tumbuhan'],

        ]);
    }
}
