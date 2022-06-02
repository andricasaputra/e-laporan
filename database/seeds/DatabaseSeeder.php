<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BkPktPemulaSeeder::class);
        $this->call(BkPktTerampilSeeder::class);
        $this->call(BkPktMahirSeeder::class);
        $this->call(BkPktPenyeliaSeeder::class);

        $this->call(BkAptPertamaSeeder::class);
        $this->call(BkAptMudaSeeder::class);
        $this->call(BkAptUtamaSeeder::class);
        $this->call(BkAptMadyaSeeder::class);
    }

}
