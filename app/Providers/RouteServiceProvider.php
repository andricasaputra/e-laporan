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
        //

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

        $this->mapAplicationManagementRoutes();

        //
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


    protected function mapOperasionalRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('intern')
             ->namespace($this->namespace . '\\Operasional')
             ->group(function(){
                Route::prefix('operasional')->group(base_path('routes/operasional.php'));
             });
    }


    protected function mapIkmRoutes()
    {
        Route::middleware('web', 'auth')
             ->prefix('intern')
             ->namespace($this->namespace . '\\Ikm')
             ->group(function(){
                Route::prefix('ikm')->group(base_path('routes/ikm.php'));
             });
    }

    protected function mapAplicationManagementRoutes()
    {
        Route::middleware('web', 'admin')
             ->prefix('intern')
             ->namespace($this->namespace)
             ->group(base_path('routes/management.php'));
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
