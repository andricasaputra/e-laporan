<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    private $namespace = 'App\Http\View\Composers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapUserAuth();

        // $this->mapIkmView();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }

    public function mapUserAuth()
    {
        View::composer(

            ['auth.register', 'auth.showusers', 'auth.edit'],
            $this->namespace . '\UsersComposer'

        );

    }

}
