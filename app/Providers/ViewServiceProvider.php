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
<<<<<<< HEAD
        // Share Data For Statistik Page KH
=======
        /*Share Data For Statistik Page KH*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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

<<<<<<< HEAD
        // Share Data For Statistik Page KH
=======
        /*Share Data For Statistik Page KH*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        View::composer(

            [
                'intern.operasional.kh.data.statistik.detail.bigtable.dokel', 
                'intern.operasional.kh.data.statistik.detail.bigtable.domas',
                'intern.operasional.kh.data.statistik.detail.bigtable.ekspor',
                'intern.operasional.kh.data.statistik.detail.bigtable.impor',
                // halaman dokumen belum terpakai
                'intern.operasional.kh.dokumen.pembatalan.index',
                'intern.operasional.kh.dokumen.penerimaan.index',
                'intern.operasional.kh.data.statistik.detail.pnbp.billing',
            ],

            $this->namespace . '\Operasional\TableDetailKhComposer'

        );

<<<<<<< HEAD
        // Share Data For Statistik Page KT
=======
        /*Share Data For Statistik Page KT*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        View::composer(

            [
                'intern.operasional.kt.data.statistik.detail.bigtable.dokel', 
                'intern.operasional.kt.data.statistik.detail.bigtable.domas',
                'intern.operasional.kt.data.statistik.detail.bigtable.ekspor',
                'intern.operasional.kt.data.statistik.detail.bigtable.impor',
                // halaman dokumen belum terpakai
                'intern.operasional.kt.dokumen.pembatalan.index',
                'intern.operasional.kt.dokumen.penerimaan.index',
                'intern.operasional.kt.data.statistik.detail.pnbp.billing',
            ],

            $this->namespace . '\Operasional\TableDetailKtComposer'

        );

<<<<<<< HEAD
        // Share Data For Page Detail Table PNBP
=======
        /*Share Data For Page Detail Table PNBP*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        View::composer(

            [
                'intern.operasional.kh.data.statistik.detail.pnbp.billing',
                'intern.operasional.kt.data.statistik.detail.pnbp.billing', 
            ],

            $this->namespace . '\Operasional\TableSetorPnbp'

        );

<<<<<<< HEAD
        // Share Data For Home Upload Page
=======
        /*Share Data For Home Upload Page*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        View::composer(

            [
                'intern.operasional.kh.upload.home_upload', 
                'intern.operasional.kt.upload.home_upload',
            ],

            $this->namespace . '\Operasional\HomeUploadPageComposer'

        );

<<<<<<< HEAD
        // Share Data For Upload Page
        View::composer(

            [
                // KH views
=======
        /*Share Data For Upload Page*/
        View::composer(

            [
                /*KH views*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
                'intern.operasional.kh.upload.dokel', 
                'intern.operasional.kh.upload.domas',
                'intern.operasional.kh.upload.ekspor',
                'intern.operasional.kh.upload.impor',
                'intern.operasional.kh.upload.pembatalan_dokumen',
                'intern.operasional.kh.upload.reekspor',
                'intern.operasional.kh.upload.serah_terima',
                'intern.operasional.kh.upload.billing',

<<<<<<< HEAD
                // KT views
=======
                /*KT views*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
                'intern.operasional.kt.upload.dokel', 
                'intern.operasional.kt.upload.domas',
                'intern.operasional.kt.upload.ekspor',
                'intern.operasional.kt.upload.impor',
                'intern.operasional.kt.upload.pembatalan_dokumen',
                'intern.operasional.kt.upload.reekspor',
                'intern.operasional.kt.upload.serah_terima',
                'intern.operasional.kt.upload.billing',

<<<<<<< HEAD
                // Admin Pengumuman
=======
                /*Admin Pengumuman*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
                'intern.operasional.admin.pengumuman.create.create',
                'intern.operasional.admin.pengumuman.create.edit',
            ],

            $this->namespace . '\Operasional\UploadPageComposer'

        );

<<<<<<< HEAD
        // Share Data For Home Download Page
=======
        /*Share Data For Home Download Page*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        View::composer(

            [
                'intern.operasional.kh.download.home_download',
                'intern.operasional.kt.download.home_download',
            ],

            $this->namespace . '\Operasional\HomeDownloadPageComposer'

        );

<<<<<<< HEAD
        // Share Data For Dokumen Page
        View::composer(

            [
                // KH views
=======
        /*Share Data For Dokumen Page*/
        View::composer(

            [
                /*KH views*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
                'intern.operasional.kh.dokumen.menu',
                'intern.operasional.kh.dokumen.data',
                'intern.operasional.kh.dokumen.penerimaan.create',
                'intern.operasional.kh.dokumen.penerimaan.edit',

<<<<<<< HEAD
                // KT views
=======
                /*KT views*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
                'intern.operasional.kt.dokumen.menu',
                'intern.operasional.kt.dokumen.data',
                'intern.operasional.kt.dokumen.penerimaan.create',
                'intern.operasional.kt.dokumen.penerimaan.edit',
            ],

            $this->namespace . '\Operasional\HomeDokumenPageComposer'

        );

    }

}
