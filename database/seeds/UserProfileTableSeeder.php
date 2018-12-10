<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profile')->insert([

        	[
        		'master_pegawai_id' => 1,
        		'nama' => 'SuperAdmin'
        	],
        	[
        		'master_pegawai_id' => 2,
        		'nama' => 'Administrator'
        	],

        ]);
    }
}
