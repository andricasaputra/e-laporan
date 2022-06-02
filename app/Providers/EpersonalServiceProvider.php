<?php

namespace App\Providers;

use Goutte\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class EpersonalServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->login();

        $this->app->singleton(Client::class, function($app) {
            return  new Client;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function login()
    {
        $this->app->singleton('login', function($app){

            $client =  $app->make(Client::class);

            $loginUri = config('epersonal.uri.login');

            $crawler = $client->request('GET', $loginUri);

            $form = $crawler->selectButton('Login')->form();

            $form['username'] = auth()->user()->username;
            
            $form['password'] = \Illuminate\Support\Facades\Crypt::decrypt(auth()->user()->e_password);

            $client->submit($form);

            return $client;

        });
    }



    public function provides()
    {
        return [Client::class, 'login'];
    }
}
