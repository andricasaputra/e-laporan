<?php

namespace App\Providers;

<<<<<<< HEAD
use Carbon\Carbon;
use Spipu\Html2Pdf\Html2Pdf;
use App\Models\MasterPegawai;
use App\Observers\UsersObserver;
=======
use Carbon;
use Spipu\Html2Pdf\Html2Pdf;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
        // Set Type Data Varchar Length To 191
        Schema::defaultStringLength(191);

        // Set Localization For Whole aplication times (Asia/Makassar, WITA)
        Carbon::setLocale(config('app.timezone'));
=======
        /*Set Type Data Varchar Length To 191*/
        Schema::defaultStringLength(191);

        /*Set Localization For Whole aplication times (Asia/Makassar, WITA)*/
        Carbon::setLocale(config('app.timezone'));

        /*Observer Class untuk insert, edit user*/
        \App\Models\MasterPegawai::observe(\App\Observers\UsersObserver::class);
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        // Register HTML2PDF Class to Service Container
=======
        /*Register HTML2PDF Class to Service Container*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        $this->app->singleton('PDF', function ($app) {

            return new Html2Pdf('P', 'A4', 'en');

        });
    }
}
