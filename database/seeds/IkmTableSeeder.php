<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now       = \Carbon::now();

    	$start1    = \Carbon::create(null, 01, 01);

    	$end1      = \Carbon::create(null, 06, 30);

    	$start2    = \Carbon::create(null, 07, 01);

    	$end2      = \Carbon::create(null, 12, 31);

		$is_open1  =  $now->between($start1, $end1) ? 1 : NULL;

		$is_open2  =  $now->between($start2, $end2) ? 1 : NULL;

        DB::connection('mysql2')->table('ikm')->insert([

        	[
	        	'start_date' => $start1,
	        	'end_date' => $end1,
	        	'is_open' => $is_open1,
	        	'keterangan' => 'IKM Periode I Tahun ' .date('Y')
        	],
        	[
	        	'start_date' => $start2,
	        	'end_date' => $end2,
	        	'is_open' => $is_open2,
	        	'keterangan' => 'IKM Periode II Tahun ' .date('Y')
        	],
        	
        ]);
    }
}
