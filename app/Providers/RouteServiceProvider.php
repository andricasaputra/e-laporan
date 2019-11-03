<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapIkmRoutes();

        $this->mapOperasionalRoutes();

        $this->mapOperasionalKhRoutes();

        $this->mapOperasionalKtRoutes();

        $this->mapNotificationsRoutes();

        $this->mapApplicationManagementRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "Global Operasional" routes for the application.
     *
     * Route utama untuk aplikasi E - Operasional, 
     * mengharuskan user untuk login terlebih dahulu
     *
     * @return void
     */
    protected function mapOperasionalRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('intern')
             ->namespace($this->namespace . '\Operasional')
             ->group(function(){
                Route::prefix('operasional')->group(base_path('routes/operasional.php'));
             });
    }

    /**
     * Define the "KH Operasional" routes for the application.
     *
     * Route utama untuk E - Operasional Karantina Hewan
     *
     * @return void
     */
    protected function mapOperasionalKhRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('kh')
             ->namespace($this->namespace . '\Operasional')
             ->group(function(){
                Route::prefix('operasional')->group(base_path('routes/operasionalkh.php'));
             });
    }

    /**
     * Define the "KT Operasional" routes for the application.
     *
     * Route utama untuk E - Operasional Karantina Tumbuhan
     *
     * @return void
     */
    protected function mapOperasionalKtRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('kt')
             ->namespace($this->namespace . '\Operasional')
             ->group(function(){
                Route::prefix('operasional')->group(base_path('routes/operasionalkt.php'));
             });
    }

    /**
     * Define the "IKM" routes for the application.
     *
     * Route utama untuk E - IKM
     *
     * @return void
     */
    protected function mapIkmRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('intern')
             ->namespace($this->namespace . '\Ikm')
             ->group(function(){
                Route::prefix('ikm')->group(base_path('routes/ikm.php'));
             });
    }

    /**
     * Define the "Manajemen Aplikasi" routes for the application.
     *
     * Route utama untuk Manajemen Aplikasi, Khusus Admin dan Role Diatasnya
     *
     * @return void
     */
    protected function mapApplicationManagementRoutes()
    {
        Route::middleware('web', 'admin')
             ->prefix('intern')
             ->namespace($this->namespace)
             ->group(base_path('routes/management.php'));
    }

    /**
     * Define the "Notifikasi" routes for the application.
     *
     * Route utama untuk Notifikasi pada semua Aplikasi
     *
     * @return void
     */
    protected function mapNotificationsRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('intern')
             ->namespace($this->namespace . '\Notifications')
             ->group(base_path('routes/notifications.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
