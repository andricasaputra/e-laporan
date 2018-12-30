<?php

use Illuminate\Database\Seeder;

class DatabaseIkmSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
        |
        | Seeder Untuk IKM Database
        |
        */

        $this->mapIkmSeeder();
    }

    public function mapIkmSeeder()
    {
        $this->call(IkmTableSeeder::class);
        $this->call(IkmLayananTableSeeder::class);
        $this->call(IkmAnswerTableSeeder::class);
        $this->call(IkmQuestionTableSeeder::class);
        $this->call(IkmAnswerQuestionTableSeeder::class);
        $this->call(IkmPekerjaanTableSeeder::class);
        $this->call(IkmPendidikanTableSeeder::class);
        $this->call(IkmUmurTableSeeder::class);
    }
}
