<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\Wilker;
use Illuminate\Http\Request;

trait DataOperasionalKtTrait
{   
    /*
    |--------------------------------------------------------------------------
    | Info
    |--------------------------------------------------------------------------
    |
    | * Trait yang dipakai untuk keperluan menampilkan kumpulan data 
    |   dari operasional karantina tumbuhan yang dibutuhkan oleh views
    |
    | * Dipakai pada class HomeKtController dan HomeAdminController
    |
    |
    */

    /**
     * Untuk Mengumpulkan data statistik yang akan digunakan oleh
     * method show pada class HomektController dan class HomeAdmin
     *
     * @return array
     */
    public function statistikDataOperasionalKt()
    {
        $data[$this->year] = [

            'tahun'  => $this->year,
            'bulan'  => $this->month,
            'wilker' => Wilker::whereId($this->wilker_id)->pluck('nama_wilker')->first(),
            'dataKt' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kt.view.page.detail.bigtable.domas', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kt.view.page.detail.bigtable.dokel', $this->routeParams)

                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kt.view.page.detail.bigtable.ekspor', $this->routeParams)

                    ],

                    'Impor Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kt.view.page.detail.bigtable.impor', $this->routeParams)

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
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->dokelTotalVolume->groupBy('sat_netto'),
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)

                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->eksporTotalVolume->groupBy('sat_netto'),
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)

                    ],

                    'Impor Karantina Tumbuhan' => [

                        'volume' => $this->ktRepository->totalRekapitulasi()->imporTotalVolume->groupBy('sat_netto'),
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)

                    ],

               ],

               'totalPNBP' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpDomas,
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)


                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpDokel,
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)


                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpEkspor,
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)


                    ],

                    'Impor Karantina Tumbuhan' => [

                        'pnbp' => $this->ktRepository->totalPnbp()->pnbpImpor,
                        'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)


                    ],

               ],

               'Dokumen' =>  [

                    'dokumen' => $this->ktRepository->pemakaianDokumen(),
                    'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)

               ],

               'PembatalanDokumen' =>  [

                    'pembatalan_dokumen' => $this->ktRepository->pembatalanDokumen(),
                    'link' => route('show.rekapitulasi.operasional.kt', $this->routeParams)

               ],

               'frekuensiKomoditiPerMonth' =>  [

                    'Domestik Masuk Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiDomas,

                    'Domestik Keluar Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiDokel,

                    'Ekspor Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiEkspor,   

                    'Impor Karantina Tumbuhan' => $this->ktRepository->frekuensiKomoditiPerMonthKt()->frekuensiKomoditiImpor

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
                        'link' => route('kt.view.page.detail.bigtable.domas', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kt.view.page.detail.bigtable.dokel', $this->routeParams)

                    ],

                    'Ekspor Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kt.view.page.detail.bigtable.ekspor', $this->routeParams)

                    ],

                    'Impor Karantina Tumbuhan' => [

                        'frekuensi' => $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kt.view.page.detail.bigtable.impor', $this->routeParams)

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
     * Untuk Menampilkan Ringkasan Data Pada Dashboard
     *
     * @return array
     */
    public function sourceDashboardApiKt()
    {
        return [

            'tahun'     =>  $this->year,

            'bulan'     =>  $this->month,

            'wilker'    =>  Wilker::whereId($this->wilker_id)->pluck('nama_wilker')->first(),

            'frekuensi' =>  $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDomas +
                            $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiDokel +
                            $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor +
                            $this->ktRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,

            'volume'    =>  collect($this->ktRepository->totalVolumePerSatuan())
                            ->flatten(1)
                            ->groupBy('sat_netto')
                            ->map(function($value, $key){

                                return number_format($value->sum('volume'), 0, ',', '.') . ' ' . ucfirst($key);

                            }),

            'pnbp'      =>  rp(
                                $this->ktRepository->totalPnbp()->pnbpDomas +
                                $this->ktRepository->totalPnbp()->pnbpDokel +
                                $this->ktRepository->totalPnbp()->pnbpEkspor +
                                $this->ktRepository->totalPnbp()->pnbpImpor
                            ),

            'dokumen'   =>  $this->ktRepository->pemakaianDokumen(),

            'topFive'   =>  collect($this->ktRepository->topFiveFrekuensiKomoditiKt())
                            ->flatten(1)
                            ->groupBy('name')
                            ->sortByDesc('data')
                            ->take(5)
                            ->map(function($value, $key){

                                return number_format($value->sum('data'), 0, ',', '.');

                            }),

        ];
    }

    /**
     * Untuk Tampilan table detail volume dokel
     *
     * @return coolections Datatables
     */
    public function dataVolumeDokelApiKt()
    {
        return datatables(

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
        return datatables(

            $this->ktRepository->totalRekapitulasi()->domasTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_komoditas"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume ekspor
     *
     * @return coolections Datatables
     */
    public function dataVolumeEksporApiKt()
    {
        return datatables(

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
        return datatables(

            $this->ktRepository->totalRekapitulasi()->imporTotalVolume

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
     * Untuk Tampilan table detail kota asal & tuju
     *
     * @param Request $request
     * @return array
     */
    public function detailTujuanKt(Request $request)
    {
        $data = $this->ktRepository->getDetailKota($request)->all();

        $table = '

        <table class="table table-detail-rekap" style="width: 100%; background-color: #fff; font-size: 10pt; font-weight: bold; text-align: center; border: solid 1px #d6d1fa"">
            <thead>
              <tr>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">KOTA ASAL</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">NEGARA ASAL</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">KOTA TUJUAN</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">NEGARA TUJUAN</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">FREKUENSI</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">VOLUME</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">SATUAN</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">DOKUMEN PELEPASAN</th>
                <th style="font-style: italic; font-weight: bold; border-bottom: solid 1px #d6d1fa">JUMLAH DOKUMEN PELEPASAN</th>
              </tr>
            </thead> 
            <tbody>';

            foreach ($data as $value) {

              $kota_asal        =  $value["kota_asal"]  ?? "IDEM";
              $kota_tuju        =  $value["kota_tuju"]  ?? "IDEM";
              $dok_pelepasan    =  $value["dok_pelepasan"] ?? "IDEM";
    
              $table .= '

                <tr>
                    <td style = "font-weight: 500">'. $kota_asal .'</td>
                    <td style = "font-weight: 500">'. $value["asal"] .'</td>
                    <td style = "font-weight: 500">'. $kota_tuju .'</td>
                    <td style = "font-weight: 500">'. $value["tujuan"] .'</td>
                    <td style = "font-weight: 500">'. $value["total"] .'</td>
                    <td style = "font-weight: 500">'. number_format((int) $value["volume"], 0, ".", ",") .'</td>
                    <td style = "font-weight: 500">'. $value["satuan"] .'</td>
                    <td style = "font-weight: 500">'. $dok_pelepasan .'</td>
                    <td style = "font-weight: 500">'. $value["pemakaian_dokumen"] .' Dokumen</td>
                </tr>';

            }
                
        $table .= '</tbody></table>';     

        return $table;
    }
    
}

