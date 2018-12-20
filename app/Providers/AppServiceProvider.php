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
        Schema::defaultStringLength(191);

        Carbon::setLocale(config('app.locale'));

        \App\Models\MasterPegawai::observe(\App\Observers\UsersObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('PDF', function ($app) {

            return new Html2Pdf('P', 'A4', 'en');

        });
    }
}
