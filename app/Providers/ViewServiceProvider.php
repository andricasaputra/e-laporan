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

        $this->mapOperasional();

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

            [
                'auth.register', 
                'auth.showusers', 
                'auth.edit'
            ],

            $this->namespace . '\UsersComposer'

        );

    }

    public function mapOperasional()
    {
        /*Share Data For Statistik Page KH*/
        View::composer(

            [
                'intern.operasional.kh.data.statistik.detail.frekuensi.dokel', 
                'intern.operasional.kh.data.statistik.detail.frekuensi.domas',
                'intern.operasional.kh.data.statistik.detail.frekuensi.ekspor',
                'intern.operasional.kh.data.statistik.detail.frekuensi.impor',
            ],

            $this->namespace . '\Operasional\TableDetailKhComposer'

        );

        /*Share Data For Statistik Page KT*/
        View::composer(

            [
                'intern.operasional.kt.data.statistik.detail.frekuensi.dokel', 
                'intern.operasional.kt.data.statistik.detail.frekuensi.domas',
                'intern.operasional.kt.data.statistik.detail.frekuensi.ekspor',
                'intern.operasional.kt.data.statistik.detail.frekuensi.impor',
            ],

            $this->namespace . '\Operasional\TableDetailKtComposer'

        );

        /*Share Data For Home Upload Page*/
        View::composer(

            [
                'intern.operasional.kh.upload.home_upload', 
                'intern.operasional.kt.upload.home_upload',
            ],

            $this->namespace . '\Operasional\HomeUploadPageComposer'

        );

        /*Share Data For Upload Page*/
        View::composer(

            [
                'intern.operasional.kh.upload.dokel', 
                'intern.operasional.kh.upload.domas',
                'intern.operasional.kh.upload.ekspor',
                'intern.operasional.kh.upload.impor',
                'intern.operasional.kt.upload.dokel', 
                'intern.operasional.kt.upload.domas',
                'intern.operasional.kt.upload.ekspor',
                'intern.operasional.kt.upload.impor',
            ],

            $this->namespace . '\Operasional\UploadPageComposer'

        );

    }

}
