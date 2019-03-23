<?php

use Illuminate\Database\Seeder;

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
        | Seeder Untuk EOffice & Setup Aplikasi Database (Default Migrations)
        |
        */

        $this->mapOperasionalSeeder();
    }

    public function mapOperasionalSeeder()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(WilkerTableSeeder::class);
        $this->call(GolonganTableSeeder::class);
        $this->call(JabatanTableSeeder::class);
        $this->call(MasterPegawaiTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WilkerUsersTableSeeder::class);
        $this->call(RoleUsersTableSeeder::class);
        $this->call(UserProfileTableSeeder::class);
    }

}
