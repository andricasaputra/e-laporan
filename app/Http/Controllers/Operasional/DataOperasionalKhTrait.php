<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\wilker;
use Illuminate\Http\Request;
use App\Http\Controllers\RupiahController as Rupiah;

trait DataOperasionalKhTrait
{   
    /**
     * Untuk Mengumpulkan data statistik yang akan digunakan oleh
     * method show pada class HomeKhController
     *
     * @return array
     */
    public function statistikDataOperasionalKh()
    {
        $data[$this->year] = [

            'tahun'  => $this->year,
            'bulan'  => $this->month,
            'wilker' => wilker::whereId($this->wilker_id)->pluck('nama_wilker')->first(),
            'dataKh' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kh.view.page.detail.frekuensi.domas', $this->params)
                    ],
                    'Domestik Keluar Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kh.view.page.detail.frekuensi.dokel', $this->params)
                    ],
                    'Ekspor Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kh.view.page.detail.frekuensi.ekspor', $this->params)
                    ],
                    'Impor Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kh.view.page.detail.frekuensi.impor', $this->params)
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
                        'link' => route('kh.view.rekapitulasi.domas', $this->params)


                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->dokelTotalVolume->groupBy('satuan'),
                        'link' => route('kh.view.rekapitulasi.dokel', $this->params)


                    ],

                    'Ekspor Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->eksporTotalVolume->groupBy('satuan'),
                        'link' => route('kh.view.rekapitulasi.ekspor', $this->params)


                    ],

                    'Impor Karantina Hewan' => [

                        'volume' => $this->khRepository->totalRekapitulasi()->imporTotalVolume->groupBy('satuan'),
                        'link' => route('kh.view.rekapitulasi.impor', $this->params)


                    ],

               ],

               'totalPNBP' =>  [

                    'Domestik Masuk Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpDomas,
                        'link' => route('kh.view.rekapitulasi.domas', $this->params)


                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpDokel,
                        'link' => route('kh.view.rekapitulasi.dokel', $this->params)


                    ],

                    'Ekspor Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpEkspor,
                        'link' => route('kh.view.rekapitulasi.ekspor', $this->params)


                    ],

                    'Impor Karantina Hewan' => [

                        'pnbp' => $this->khRepository->totalPnbp()->pnbpImpor,
                        'link' => route('kh.view.rekapitulasi.impor', $this->params)


                    ],

               ],

               'Dokumen' =>  [

                    'Domestik Masuk Karantina Hewan' => [

                        'dokumen' => $this->khRepository->pemakaianDokumen()->dokumenDomas,
                        'link' => route('kh.view.rekapitulasi.domas', $this->params)


                    ],

                    'Domestik Keluar Karantina Hewan' => [

                        'dokumen' => $this->khRepository->pemakaianDokumen()->dokumenDokel,
                        'link' => route('kh.view.rekapitulasi.dokel', $this->params)


                    ],

                    'Ekspor Karantina Hewan' => [

                        'dokumen' => $this->khRepository->pemakaianDokumen()->dokumenEkspor,
                        'link' => route('kh.view.rekapitulasi.ekspor', $this->params)


                    ],

                    'Impor Karantina Hewan' => [

                        'dokumen' => $this->khRepository->pemakaianDokumen()->dokumenImpor,
                        'link' => route('kh.view.rekapitulasi.impor', $this->params)


                    ],

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
            'wilker' => wilker::whereId($this->wilker_id)->pluck('nama_wilker')->first(),
            'dataKh' => [

               'frekuensiPerKegiatan' => [

                    'Domestik Masuk Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDomas,
                        'link' => route('kh.view.page.detail.frekuensi.domas', $this->params)
                    ],
                    'Domestik Keluar Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiDokel,
                        'link' => route('kh.view.page.detail.frekuensi.dokel', $this->params)
                    ],
                    'Ekspor Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiEkspor,
                        'link' => route('kh.view.page.detail.frekuensi.ekspor', $this->params)
                    ],
                    'Impor Karantina Hewan' => [
                        'frekuensi' => $this->khRepository->totalFrekuensiPerKegiatan()->frekuensiImpor,
                        'link' => route('kh.view.page.detail.frekuensi.impor', $this->params)
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
     * Untuk Tampilan table detail volume dokel
     *
     * @return coolections Datatables
     */
    public function dataVolumeDokelApiKh()
    {
        return app('DataTables')::of(

            $this->khRepository->totalRekapitulasi()->dokelTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_mp"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume domas
     *
     * @return coolections Datatables
     */
    public function dataVolumeDomasApiKh()
    {
        return app('DataTables')::of(

            $this->khRepository->totalRekapitulasi()->domasTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_mp"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume ekspor
     *
     * @return coolections Datatables
     */
    public function dataVolumeEksporApiKh()
    {
        return app('DataTables')::of(

            $this->khRepository->totalRekapitulasi()->eksporTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_mp"].'" class="btn btn-primary detail-mp">
                <i class="fa fa-edit"></i> Detail MP
            </a>';
        })->make(true);
    }

    /**
     * Untuk Tampilan table detail volume impor
     *
     * @return coolections Datatables
     */
    public function dataVolumeImporApiKh()
    {
        return app('DataTables')::of(

            $this->khRepository->totalRekapitulasi()->imporTotalVolume

        )->addColumn('action', function ($mp){
            return '
            <a href="#" data-mp="'.$mp["nama_mp"].'" class="btn btn-primary detail-mp">
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

