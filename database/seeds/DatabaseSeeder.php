<?php

use Illuminate\Database\Seeder;
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
        /*
        |
        |Seeder Untuk EOffice & Setup Aplikasi Database (Default Migrations)
        |
        */

        $this->call(RolesTableSeeder::class);
        $this->call(WilkerTableSeeder::class);
        $this->call(GolonganTableSeeder::class);
        $this->call(JabatanTableSeeder::class);
        $this->call(MasterPegawaiTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WilkerUsersTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);
        $this->call(UserProfileTableSeeder::class);

        /*
        |
        |Seeder Untuk IKM Database
        |
        */

        // $this->call(IkmTableSeeder::class);
        // $this->call(IkmLayananTableSeeder::class);
        // $this->call(IkmAnswerTableSeeder::class);
        // $this->call(IkmQuestionTableSeeder::class);
        // $this->call(IkmAnswerQuestionTableSeeder::class);
        // $this->call(IkmPekerjaanTableSeeder::class);
        // $this->call(IkmPendidikanTableSeeder::class);
        // $this->call(IkmUmurTableSeeder::class);
    }
}
