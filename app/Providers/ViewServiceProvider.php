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

    /**
     * Inventarisir/ Mapping view untuk manajemen user.
     *
     * @return void
     */
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

    /**
     * Populasi/ Mapping view untuk E- Operasional
     *
     * @return void
     */
    public function mapOperasional()
    {
        /*Share Data For Statistik Page KH*/
        View::composer(

            [
                'intern.operasional.home', 
                'intern.operasional.kh.data.rekapitulasi.home',
                'intern.operasional.kh.data.statistik.home',
                'intern.operasional.kt.data.rekapitulasi.home',
                'intern.operasional.kt.data.statistik.home',
            ],

            $this->namespace . '\Operasional\HomeComposer'

        );

        /*Share Data For Statistik Page KH*/
        View::composer(

            [
                'intern.operasional.kh.data.statistik.detail.bigtable.dokel', 
                'intern.operasional.kh.data.statistik.detail.bigtable.domas',
                'intern.operasional.kh.data.statistik.detail.bigtable.ekspor',
                'intern.operasional.kh.data.statistik.detail.bigtable.impor',
                'intern.operasional.kh.data.statistik.detail.dokumen.pembatalan_dokumen',
            ],

            $this->namespace . '\Operasional\TableDetailKhComposer'

        );

        /*Share Data For Statistik Page KT*/
        View::composer(

            [
                'intern.operasional.kt.data.statistik.detail.bigtable.dokel', 
                'intern.operasional.kt.data.statistik.detail.bigtable.domas',
                'intern.operasional.kt.data.statistik.detail.bigtable.ekspor',
                'intern.operasional.kt.data.statistik.detail.bigtable.impor',
                'intern.operasional.kt.dokumen.pembatalan.index',
                'intern.operasional.kt.dokumen.penerimaan.index',
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
                /*KH views*/
                'intern.operasional.kh.upload.dokel', 
                'intern.operasional.kh.upload.domas',
                'intern.operasional.kh.upload.ekspor',
                'intern.operasional.kh.upload.impor',
                'intern.operasional.kh.upload.pembatalan_dokumen',
                'intern.operasional.kh.upload.reekspor',
                'intern.operasional.kh.upload.serah_terima',

                /*KT views*/
                'intern.operasional.kt.upload.dokel', 
                'intern.operasional.kt.upload.domas',
                'intern.operasional.kt.upload.ekspor',
                'intern.operasional.kt.upload.impor',
                'intern.operasional.kt.upload.pembatalan_dokumen',
                'intern.operasional.kt.upload.reekspor',
                'intern.operasional.kt.upload.serah_terima',

                /*Admin Pengumuman*/
                'intern.operasional.admin.pengumuman.create.create',
                'intern.operasional.admin.pengumuman.create.edit',
            ],

            $this->namespace . '\Operasional\UploadPageComposer'

        );

        /*Share Data For Home Download Page*/
        View::composer(

            [
                'intern.operasional.kh.download.home_download',
                'intern.operasional.kt.download.home_download',
            ],

            $this->namespace . '\Operasional\HomeDownloadPageComposer'

        );

        /*Share Data For Dokumen Page*/
        View::composer(

            [
                /*KH views*/
                'intern.operasional.kh.dokumen.menu',
                'intern.operasional.kh.dokumen.data',
                'intern.operasional.kh.dokumen.penerimaan.create',
                'intern.operasional.kh.dokumen.penerimaan.edit',

                /*KT views*/
                'intern.operasional.kt.dokumen.menu',
                'intern.operasional.kt.dokumen.data',
                'intern.operasional.kt.dokumen.penerimaan.create',
                'intern.operasional.kt.dokumen.penerimaan.edit',
            ],

            $this->namespace . '\Operasional\HomeDokumenPageComposer'

        );

    }

}
