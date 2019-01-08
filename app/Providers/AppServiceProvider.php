<?php

namespace App\Providers;

use Carbon;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Set Type Data Varchar Length To 191*/
        Schema::defaultStringLength(191);

        /*Set Localization For Whole aplication times (Asia/Makassar, WITA)*/
        Carbon::setLocale(config('app.timezone'));

        /*Observer Class untuk insert, edit user*/
        \App\Models\MasterPegawai::observe(\App\Observers\UsersObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*Register HTML2PDF Class to Service Container*/
        $this->app->singleton('PDF', function ($app) {

            return new Html2Pdf('P', 'A4', 'en');

        });
    }
}
