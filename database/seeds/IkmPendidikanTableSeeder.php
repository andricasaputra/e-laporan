<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmPendidikanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ikm_pendidikan')->insert([

        	['pendidikan' => 'SD'],
        	['pendidikan' => 'SLTP'],
        	['pendidikan' => 'SLTA'],
        	['pendidikan' => 'D1/D2/D3'],
        	['pendidikan' => 'S1'],
        	['pendidikan' => 'S2'],
        	['pendidikan' => 'S3']

        ]);
    }
}
