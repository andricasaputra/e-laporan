<?php

declare(strict_types = 1);

namespace App\Traits\Operasional;

use App\Models\Wilker;
use Illuminate\Http\Request;

trait DataOperasionalKhTrait
{   
    /*
    |--------------------------------------------------------------------------
    | Info
    |--------------------------------------------------------------------------
    |
    | * Trait yang dipakai untuk keperluan menampilkan kumpulan data 
    |   dari operasional karantina hewan yang dibutuhkan oleh views
    |
    | * Dipakai pada class HomeKhController dan HomeAdminController
    |
    |
    */

    /**
     * Untuk Menampilkan Ringkasan Data Pada Dashboard
     *
     * @return array
     */
    public function sourceDashboardApiKh()
    {
        return [

            'tahun'     =>  $this->year,

            'bulan'     =>  $this->month,

            'wilker'    =>  Wilker::whereId($this->wilker_id)->first(),

            'frekuensi' =>  $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDomas +
                            $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDokel +
                            $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor +
                            $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,

            'frekuensiPerKegiatan' =>  [

              'domas' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
              'dokel' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
              'ekspor' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
              'impor' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
              
            ],

            'volume'    =>  collect($this->khRepository->totalVolumePerSatuan())
                            ->flatten(1)
                            ->groupBy('satuan')
                            ->map(function($value, $key){

                                return number_format($value->sum('volume'), 0, ',', '.') . ' ' . ucfirst($key);

                            }),

            'pnbp'      =>  rp(
                                $this->khRepository->totalPnbp()->pnbpDomas +
                                $this->khRepository->totalPnbp()->pnbpDokel +
                                $this->khRepository->totalPnbp()->pnbpEkspor +
                                $this->khRepository->totalPnbp()->pnbpImpor
                            ),

            'dokumen'   =>  $this->khRepository->pemakaianDokumen(),

            'topFive'   =>  collect($this->khRepository->topFiveFrekuensiKomoditiKh())
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
     * Untuk Mengumpulkan data statistik yang akan digunakan oleh
     * method show pada class HomeKhController dan class HomeAdmin
     *
     * @return array
     */
    public function statistikDataOperasionalKh()
    {
        $data[$this->year] = [

            'tahun'  => $this->year,
            'bulan'  => $this->month,
            'wilker' => Wilker::whereId($this->wilker_id)->first(),
            'dataKh' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kh.view.page.detail.bigtable.domas', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kh.view.page.detail.bigtable.dokel', $this->routeParams)

                    ],

                    'Ekspor Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kh.view.page.detail.bigtable.ekspor', $this->routeParams)

                    ],

                    'Impor Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kh.view.page.detail.bigtable.impor', $this->routeParams)

                    ]

                ],

               'totalVolume' =>  [

                    'Domestik Masuk Karantina Hewan' => $this->khRepository->totalRekapitulasi()->domasTotalVolume,

                    'Domestik Keluar Karantina Hewan' => $this->khRepository->totalRekapitulasi()->dokelTotalVolume,

                    'Ekspor Karantina Hewan' => $this->khRepository->totalRekapitulasi()->eksporTotalVolume,

                    'Impor Karantina Hewan' => $this->khRepository->totalRekapitulasi()->imporTotalVolume,

               ],

               'totalVolumeBySatuan' =>  [

                    'Domestik Masuk Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->domasTotalVolume->groupBy('satuan'),
                        'link' => route('show.rekapitulasi.operasional.kh', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->dokelTotalVolume->groupBy('satuan'),
                        'link' => route('show.rekapitulasi.operasional.kh', $this->routeParams)

                    ],

                    'Ekspor Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->eksporTotalVolume->groupBy('satuan'),
                        'link' => route('show.rekapitulasi.operasional.kh', $this->routeParams)

                    ],

                    'Impor Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->imporTotalVolume->groupBy('satuan'),
                        'link' => route('show.rekapitulasi.operasional.kh', $this->routeParams)

                    ],

               ],

               'totalPNBP' =>  [

                    'Domestik Masuk Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpDomas,
                        'link' => route('kh.view.page.detail.pnbp.setor', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpDokel,
                        'link' => route('kh.view.page.detail.pnbp.setor', $this->routeParams)

                    ],

                    'Ekspor Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpEkspor,
                        'link' => route('kh.view.page.detail.pnbp.setor', $this->routeParams)

                    ],

                    'Impor Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpImpor,
                        'link' => route('kh.view.page.detail.pnbp.setor', $this->routeParams)

                    ],

               ],

               'Dokumen' =>  [

                    'dokumen' => $this->khRepository->pemakaianDokumen(),
                    'link' => route('show.rekapitulasi.operasional.kh', $this->routeParams)

               ],

               'PembatalanDokumen' =>  [

                    'pembatalan_dokumen' => $this->khRepository->pembatalanDokumen(),
                    'link' => route('show.rekapitulasi.operasional.kh', $this->routeParams)

               ],

            ]
            
        ];

        return $data[$this->year];
    }

    /**
     * Untuk Mengumpulkan data utama yang akan digunakan oleh
     * method show pada class HomeKhController
     *
     * @return array
     */
    public function rekapitulasiDataOperasionalKh()
    {
        $data[$this->year] = [

            'tahun'  => $this->year,
            'bulan'  => $this->month,
            'wilker' => Wilker::whereId($this->wilker_id)->first(),
            'dataKh' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kh.view.page.detail.bigtable.domas', $this->routeParams)

                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kh.view.page.detail.bigtable.dokel', $this->routeParams)

                    ],

                    'Ekspor Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kh.view.page.detail.bigtable.ekspor', $this->routeParams)

                    ],

                    'Impor Karantina Hewan' => [

                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kh.view.page.detail.bigtable.impor', $this->routeParams)

                    ]
                ],

               'totalVolume' =>  [

                    'Domestik Masuk Karantina Hewan' => $this->khRepository->totalRekapitulasi()->domasTotalVolume,

                    'Domestik Keluar Karantina Hewan' => $this->khRepository->totalRekapitulasi()->dokelTotalVolume,

                    'Ekspor Karantina Hewan' => $this->khRepository->totalRekapitulasi()->eksporTotalVolume,

                    'Impor Karantina Hewan' => $this->khRepository->totalRekapitulasi()->imporTotalVolume,

               ],

            ]
            
        ];

        return $data[$this->year];
    }

    /**
     * Untuk Tampilan chart frekuensi
     *
     * @param string $tipe_karantina
     * @return array
     */
    public function frekuensiChartKh($type_karantina = null)
    {
        $frekuensi = [

            'domaskh' => $this->khRepository->frekuensiByKomoditiKh()->frekuensiKomoditiDomas,

            'dokelkh' => $this->khRepository->frekuensiByKomoditiKh()->frekuensiKomoditiDokel,

            'eksporkh' => $this->khRepository->frekuensiByKomoditiKh()->frekuensiKomoditiEkspor,   

            'imporkh' => $this->khRepository->frekuensiByKomoditiKh()->frekuensiKomoditiImpor

       ];

      return $frekuensi[$type_karantina]; 
    }

    /**
     * Untuk Tampilan table detail volume dokel
     *
     * @return Collection datatables
     */
    public function volumeDokelApiKh()
    {
        return datatables(

            $this->khRepository->totalRekapitulasi()->dokelTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'. $mp["nama_mp"] .'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume domas
     *
     * @return Collection datatables
     */
    public function volumeDomasApiKh()
    {
        return datatables(

            $this->khRepository->totalRekapitulasi()->domasTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'. $mp["nama_mp"] .'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume ekspor
     *
     * @return Collection datatables
     */
    public function volumeEksporApiKh()
    {
        return datatables(

            $this->khRepository->totalRekapitulasi()->eksporTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'. $mp["nama_mp"] .'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume impor
     *
     * @return Collection datatables
     */
    public function volumeImporApiKh()
    {
        return datatables(

            $this->khRepository->totalRekapitulasi()->imporTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'. $mp["nama_mp"] .'" class="btn btn-primary detail-mp">
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
    public function detailTujuanKh(Request $request)
    {
        $data = $this->khRepository->getDetailKota($request)->all();

        $table = '

        <table class="table table-detail-rekap" style="width: 100%; background-color: #fff; font-size: 10pt; font-weight: bold; text-align: center; border: solid 1px #d6d1fa">
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

              $kota_asal        =  $value["kota_asal"] ?? "IDEM";
              $kota_tuju        =  $value["kota_tuju"] ?? "IDEM";
              $dok_pelepasan    =  $value["dok_pelepasan"] ?? "IDEM";

              $table .= '

                <tr>
                    <td style="font-weight: 500">'. $kota_asal .'</td>
                    <td style="font-weight: 500">'. $value["asal"] .'</td>
                    <td style="font-weight: 500">'. $kota_tuju .'</td>
                    <td style="font-weight: 500">'. $value["tujuan"] .'</td>
                    <td style="font-weight: 500">'. $value["total"] .'</td>
                    <td style="font-weight: 500">'. $value["volume"] .'</td>
                    <td style="font-weight: 500">'. $value["satuan"] .'</td>
                    <td style="font-weight: 500">'. $dok_pelepasan .'</td>
                    <td style="font-weight: 500">'. $value["pemakaian_dokumen"] .' Dokumen</td>
                </tr>';

            }
                
        $table .= '</tbody></table>';     

        return $table;
    }
    
}

