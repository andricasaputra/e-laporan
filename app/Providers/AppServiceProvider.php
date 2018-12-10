<?php

namespace App\Providers;

use Carbon;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\MasterPegawaiObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Carbon::setLocale(config('app.locale'));

        MasterPegawai::observe(MasterPegawaiObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
