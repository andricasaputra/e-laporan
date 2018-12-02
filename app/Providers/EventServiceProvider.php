<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\RegisterPegawai' => [
            'App\Listeners\UserAccountRegister',
            'App\Listeners\CreateUserProfile',
        ],
        'App\Events\UpdatePegawai' => [
            'App\Listeners\UserAccountUpdate',
            'App\Listeners\UpdateUserProfile',
        ],
        'App\Events\DeletePegawai' => [
            'App\Listeners\UserAccountDelete',
            'App\Listeners\DeleteUserProfile',
        ],
        'App\Events\MainNotificationsEvent' => [
            'App\Listeners\MainNotificationsListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
