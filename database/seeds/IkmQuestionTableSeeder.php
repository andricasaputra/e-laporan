<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkmQuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ikm_question')->insert([

        	[
        		'question' => 'Bagaimana pendapat saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?'
        	],
        	[
        		'question' => 'Bagaimana pemahaman saudara tentang kemudahan prosedur pelayanan unit ini?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang kecepatan waktu  dalam memberikan pelayanan?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang kewajaran biaya/tarif dalam pelayanan?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan hasil yang diberikan?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang kompetensi/ kemampuan petugas pelayanan?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang penanganan pengaduan pengguna layanan?'
        	],
        	[
        		'question' => 'Bagaimana pendapat saudara tentang kualitas sarana dan prasarana?'
        	],

        ]);
    }
}
