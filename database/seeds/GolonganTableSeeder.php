<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('golongan')->insert([
            
            [
            	'pangkat' => 'Juru Muda',
            	'golongan' => 'I/a'
        	],
        	[
            	'pangkat' => 'Juru Muda Tingkat I',
            	'golongan' => 'I/b'
        	],
        	[
            	'pangkat' => 'Juru',
            	'golongan' => 'I/c'
        	],
        	[
            	'pangkat' => 'Juru Tingkat I',
            	'golongan' => 'I/d'
        	],
        	[
            	'pangkat' => 'Pengatur Muda',
            	'golongan' => 'II/a'
        	],
        	[
            	'pangkat' => 'Pengatur Muda Tingkat I',
            	'golongan' => 'II/b'
        	],
        	[
            	'pangkat' => 'Pengatur',
            	'golongan' => 'II/c'
        	],
        	[
            	'pangkat' => 'Pengatur Tingkat I',
            	'golongan' => 'II/d'
        	],
        	[
            	'pangkat' => 'Panata Muda',
            	'golongan' => 'III/a'
        	],
        	[
            	'pangkat' => 'Panata Muda Tingkat I',
            	'golongan' => 'III/b'
        	],
        	[
            	'pangkat' => 'Panata',
            	'golongan' => 'III/c'
        	],
        	[
            	'pangkat' => 'Panata Tingkat I',
            	'golongan' => 'III/d'
        	],
        	[
            	'pangkat' => 'Pembina',
            	'golongan' => 'IV/a'
        	],
        	[
            	'pangkat' => 'Pembina Tingkat I',
            	'golongan' => 'IV/b'
        	],
        	[
            	'pangkat' => 'Pembina Utama Muda',
            	'golongan' => 'IV/c'
        	],
        	[
            	'pangkat' => 'Pembina Utama Madya',
            	'golongan' => 'IV/d'
        	],
        	[
            	'pangkat' => 'Pembina Utama',
            	'golongan' => 'IV/e'
        	]
        ]);
    }
}
