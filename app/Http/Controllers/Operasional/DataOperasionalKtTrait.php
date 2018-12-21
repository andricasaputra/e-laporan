<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\wilker;
use Illuminate\Http\Request;
use App\Http\Controllers\RupiahController as Rupiah;

trait DataOperasionalKtTrait
{   
    /**
     * Untuk Mengumpulkan data statistik yang akan digunakan oleh
     * method show pada class HomektController
     *
     * @return array
     */
    public function statistikDataOperasionalKt()
    {
        $data[$this->year] = [

            'tahun'  => $this->year,
            'bulan'  => $this->month,
            'wilker' => wilker::whereId($this->wilker_id)->pluck('nama_wilker')->first(),
            'dataKt' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kt.view.page.detail.frekuensi.domas', $this->params)
                    ],
                    'Domestik Keluar Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kt.view.page.detail.frekuensi.dokel', $this->params)
                    ],
                    'Ekspor Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kt.view.page.detail.frekuensi.ekspor', $this->params)
                    ],
                    'Impor Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kt.view.page.detail.frekuensi.impor', $this->params)
                    ]
                ],

               'totalVolume' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->domasTotalVolume,

                    'Domestik Keluar Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->dokelTotalVolume,

                    'Ekspor Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->eksporTotalVolume,

                    'Impor Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->imporTotalVolume,

               ],

               'totalVolumeBySatuan' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->domasTotalVolume->groupBy('sat_netto'),
                        'link' => route('kt.view.rekapitulasi.domas', $this->params)


                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->dokelTotalVolume->groupBy('sat_netto'),
                        'link' => route('kt.view.rekapitulasi.dokel', $this->params)


                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->eksporTotalVolume->groupBy('sat_netto'),
                        'link' => route('kt.view.rekapitulasi.ekspor', $this->params)


                    ],

                    'Impor Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->imporTotalVolume->groupBy('sat_netto'),
                        'link' => route('kt.view.rekapitulasi.impor', $this->params)


                    ],

               ],

               'totalPNBP' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpDomas,
                        'link' => route('kt.view.rekapitulasi.domas', $this->params)


                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpDokel,
                        'link' => route('kt.view.rekapitulasi.dokel', $this->params)


                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpEkspor,
                        'link' => route('kt.view.rekapitulasi.ekspor', $this->params)


                    ],

                    'Impor Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpImpor,
                        'link' => route('kt.view.rekapitulasi.impor', $this->params)


                    ],

               ],

               'Dokumen' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => [

                        'dokumen' => $this->ktRepository->pemakaianDokumen()->dokumenDomas,
                        'link' => route('kt.view.rekapitulasi.domas', $this->params)


                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'dokumen' => $this->ktRepository->pemakaianDokumen()->dokumenDokel,
                        'link' => route('kt.view.rekapitulasi.dokel', $this->params)


                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'dokumen' => $this->ktRepository->pemakaianDokumen()->dokumenEkspor,
                        'link' => route('kt.view.rekapitulasi.ekspor', $this->params)


                    ],

                    'Impor Karantina Tumbuhan' => [

                        'dokumen' => $this->ktRepository->pemakaianDokumen()->dokumenImpor,
                        'link' => route('kt.view.rekapitulasi.impor', $this->params)


                    ],

               ],

               'frekuensiKomoditiPerMonth' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiDomas,

                    'Domestik Keluar Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiDokel,

                    'Ekspor Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiEkspor,   

                    'Impor Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiImpor

               ],

               'topFiveFrekuensiKomoditi' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => $this->ktRepository->topFiveFrekuensiKomoditiKt()->topFiveFrekuensiKomoditiDomas,

                    'Domestik Keluar Karantina Tumbuhan' => $this->ktRepository->topFiveFrekuensiKomoditiKt()->topFiveFrekuensiKomoditiDokel,

                    'Ekspor Karantina Tumbuhan' => $this->ktRepository->topFiveFrekuensiKomoditiKt()->topFiveFrekuensiKomoditiEkspor,   

                    'Impor Karantina Tumbuhan' => $this->ktRepository->topFiveFrekuensiKomoditiKt()->topFiveFrekuensiKomoditiImpor

               ],
            ]
            
        ];

        return $data[$this->year];
    }

    /**
     * Untuk Mengumpulkan data utama yang akan digunakan oleh
     * method show pada class HomektController
     *
     * @return array
     */
    public function rekapitulasiDataOperasionalKt()
    {
        $data[$this->year] = [

            'tahun'  => $this->year,
            'bulan'  => $this->month,
            'wilker' => wilker::whereId($this->wilker_id)->pluck('nama_wilker')->first(),
            'dataKt' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kt.view.page.detail.frekuensi.domas', $this->params)
                    ],
                    'Domestik Keluar Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kt.view.page.detail.frekuensi.dokel', $this->params)
                    ],
                    'Ekspor Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kt.view.page.detail.frekuensi.ekspor', $this->params)
                    ],
                    'Impor Karantina Tumbuhan' => [
                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kt.view.page.detail.frekuensi.impor', $this->params)
                    ]
                ],

               'totalVolume' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->domasTotalVolume,

                    'Domestik Keluar Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->dokelTotalVolume,

                    'Ekspor Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->eksporTotalVolume,

                    'Impor Karantina Tumbuhan' => $this->ktRepository->totalRekapitulasi()->imporTotalVolume,

               ],

            ]
            
        ];

        return $data[$this->year];
    }

    /**
     * Untuk Tampilan table detail volume dokel
     *
     * @return coolections Datatables
     */
    public function dataVolumeDokelApiKt()
    {
        return app('DataTables')::of(

            $this->ktRepository->totalRekapitulasi()->dokelTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_komoditas"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume domas
     *
     * @return coolections Datatables
     */
    public function dataVolumeDomasApiKt()
    {
        return app('DataTables')::of(

            $this->ktRepository->totalRekapitulasi()->domasTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_komoditas"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan chart frekuensi
     *
     * @param string $tipe_karantina
     * @return array
     */
    public function frekuensiPerMonthChartKt($type_karantina = null)
    {
        $frekuensi = [

            'Domestik Masuk Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiDomas,

            'Domestik Keluar Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiDokel,

            'Ekspor Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiEkspor,   

            'Impor Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiImpor

       ];

      return $frekuensi[$type_karantina]; 
    }

    /**
     * Untuk Tampilan table detail volume ekspor
     *
     * @return coolections Datatables
     */
    public function dataVolumeEksporApiKt()
    {
        return app('DataTables')::of(

            $this->ktRepository->totalRekapitulasi()->eksporTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_komoditas"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume impor
     *
     * @return coolections Datatables
     */
    public function dataVolumeImporApiKt()
    {
        return app('DataTables')::of(

            $this->ktRepository->totalRekapitulasi()->imporTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_komoditas"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail kota asal & tuju
     *
     * @param Request $request
     * @return array
     */
    public function detailTujuanKt(Request $request)
    {
        $data = $this->ktRepository->getDetailKota($request)->all();

        $table = '

        <table class="table" style="width: 100%; background-color: #fff; font-size: 10pt; font-weight: bold; text-align: center; border: solid 1px #d6d1fa">
            <thead>
              <tr>
                <th style="font-style: italic; border: solid 1px #d6d1fa">KOTA ASAL</th>
                <th style="font-style: italic; border: solid 1px #d6d1fa">KOTA TUJUAN</th>
                <th style="font-style: italic; border: solid 1px #d6d1fa">FREKUENSI</th>
                <th style="font-style: italic; border: solid 1px #d6d1fa">DOKUMEN PELEPASAN</th>
                <th style="font-style: italic; border: solid 1px #d6d1fa">JUMLAH DOKUMEN PELEPASAN</th>
              </tr>
            </thead> 
            <tbody>';

            foreach ($data as $value) {
    
              $table .= '

                <tr>
                    <td style="border: solid 1px #d6d1fa">'. $value["kota_asal"] .'</td>
                    <td style="border: solid 1px #d6d1fa">'. $value["kota_tuju"] .'</td>
                    <td style="border: solid 1px #d6d1fa">'. $value["total"] .'</td>
                    <td style="border: solid 1px #d6d1fa">'. $value["dok_pelepasan"] .'</td>
                    <td style="border: solid 1px #d6d1fa">'. $value["pemakaian_dokumen"] .' Dokumen</td>
                </tr>';

            }
                
        $table .= '</tbody></table>';     

        return $table;
    }
    
}

