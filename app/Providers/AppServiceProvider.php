<?php

namespace App\Providers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Spipu\Html2Pdf\Html2Pdf;
use App\Models\MasterPegawai;
use App\Observers\UsersObserver;
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
        // Set Type Data Varchar Length To 191
        Schema::defaultStringLength(191);

        // Set Localization For Whole aplication times (Asia/Makassar, WITA)
        Carbon::setLocale(config('app.timezone'));

        $this->loadMigrationsFrom($this->getMigrationPath());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register HTML2PDF Class to Service Container
        $this->app->singleton('PDF', function ($app) {
            return new Html2Pdf('P', 'A4', 'en');
        });

        $this->app->singleton('Client', function ($app) {
            return new Client;
        });
    }

    private function getMigrationPath()
    {
        $mainPath = database_path('migrations/e-operasional');

        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);

        return  array_merge([$mainPath], $directories);
    }
}
