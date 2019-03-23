<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmAnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql2')->table('ikm_answer')->insert([

        	[
        		'answer' => 'Tidak sesuai',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Kurang sesuai',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Sesuai',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Sangat Sesuai',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Tidak mudah',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Kurang mudah',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Mudah',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Sangat mudah',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Tidak cepat',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Kurang cepat',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Cepat',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Sangat cepat',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Sangat mahal',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Cukup mahal',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Murah',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Gratis',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Tidak kompeten',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Kurang kompeten',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Kompeten',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Sangat kompeten',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Tidak sopan dan ramah',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Kurang sopan dan ramah',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Sopan dan ramah',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Sangat sopan dan ramah',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Buruk',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Cukup',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Baik',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Sangat baik',
        		'nilai' => '4'
        	],
        	[
        		'answer' => 'Tidak ada',
        		'nilai' => '1'
        	],
        	[
        		'answer' => 'Ada tetapi tidak berfungsi',
        		'nilai' => '2'
        	],
        	[
        		'answer' => 'Berfungsi kurang maksimal',
        		'nilai' => '3'
        	],
        	[
        		'answer' => 'Dikelola dengan baik',
        		'nilai' => '4'
        	],

        ]);
    }
}
