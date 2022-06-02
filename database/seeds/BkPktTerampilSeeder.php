<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class BkPktTerampilSeeder extends CsvSeeder
{
    public function __construct()
    {
       $this->table = 'bk_pkt_terampil';
        $this->filename = base_path().'/database/seeds/csv/bk_pkt_terampil.csv';
    }

    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();

        parent::run();
    }
}
