<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilkerUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wilker_user')->insert([

        	[
        		'user_id' => 1,
        		'wilker_id' => 1
        	],
        	[
        		'user_id' => 2,
        		'wilker_id' => 1
        	],


        ]);
    }
}
