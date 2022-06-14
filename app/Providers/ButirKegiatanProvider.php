<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ButirKegiatanProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->checkJabatan();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function checkJabatan()
    {
        $this->app->bind('BK', function($app){

            return match (auth()->user()->pegawai->jabatan) {
                'PEMERIKSA KARANTINA TUMBUHAN PEMULA' => \App\Models\ButirPktPemula::class,
                'PEMERIKSA KARANTINA TUMBUHAN TERAMPIL' => \App\Models\ButirPktTerampil::class,
                'PEMERIKSA KARANTINA TUMBUHAN MAHIR' => \App\Models\ButirPktMahir::class,
                'PEMERIKSA KARANTINA TUMBUHAN PENYELIA' => \App\Models\ButirPktPenyelia::class,

                'ANALIS PERKARANTINAAN TUMBUHAN PERTAMA' => \App\Models\ButirAptPertama::class,
                'ANALIS PERKARANTINAAN TUMBUHAN MUDA' => \App\Models\ButirAptMuda::class,
                'ANALIS PERKARANTINAAN TUMBUHAN UTAMA' => \App\Models\ButirAptUtama::class,
                'ANALIS PERKARANTINAAN TUMBUHAN MADYA' => \App\Models\ButirAptMadya::class,

                default => throw new \Exception("Error Jabatan Tidak Ditemukan", 1),
                
            };
        });
    }

}
