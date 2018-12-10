<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\MainRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\RepositoryViewInterface;

class RepositoriesServicesProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, UserRepository::class);
    }
}
