<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class BkPktPemulaSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'bk_pkt_pemula';
        $this->filename = base_path().'/database/seeds/csv/bk_pkt_pemula.csv';
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