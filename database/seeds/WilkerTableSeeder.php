<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wilker')->insert([

            ['nama_wilker' => 'Kantor Induk'],
            ['nama_wilker' => 'Wilker Pelabuhan Ferry Poto Tano'],
            ['nama_wilker' => 'Wilker Pelabuhan Laut Benete'],
            ['nama_wilker' => 'Wilker Pelabuhan Laut Badas'],
            ['nama_wilker' => 'Wilker Bandara Sultan M.Kaharuddin'],
            ['nama_wilker' => 'Wilker Pelabuhan Laut Soro Kempo'],
            ['nama_wilker' => 'Wilker Bandara Sultan M.Salahuddin'],
            ['nama_wilker' => 'Wilker Pelabuhan Laut Bima'],
            ['nama_wilker' => 'Wilker Pelabuhan Ferry Sape']
            
        ]);
    }
}
