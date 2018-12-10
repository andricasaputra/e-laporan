<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Wilker;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(

            ['auth.register', 'auth.showusers'],
            'App\Http\View\Composers\UsersComposer'

        );

        // Using Closure based composers...
        View::composer('auth.edit', function ($view) {

            $view->with('roles', Role::where('id', '!=', 1)->get()); 

            $view->with('wilkers', Wilker::all()); 

            $view->with('jabatan', Jabatan::all());

            $view->with('golongan', Golongan::all());
            
        });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton('App\Http\View\Composers\UsersComposer');
    }
}
