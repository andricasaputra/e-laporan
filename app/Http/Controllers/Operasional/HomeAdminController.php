<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Models\Operasional\DokelKh; 
use App\Models\Operasional\DomasKh; 
use App\Models\Operasional\ImporKh; 
use App\Models\Operasional\DokelKt; 
use App\Models\Operasional\DomasKt; 
use App\Models\Operasional\ImporKt;
use App\Models\Operasional\EksporKt; 
use App\Models\Operasional\EksporKh;  
use App\Http\Controllers\Controller; 
use App\Http\Controllers\TanggalController;
use App\Http\Controllers\RupiahController as Rupiah;

class HomeAdminController extends Controller
{
    public function show(int $year = null, string $month = null)
    {
    	$year = $year ?? date('Y');

    	return view('intern.operasional.home')
    	->with('datas', $this->dataOperasional($year, $month));
    }

    public function dataOperasional($year, $month = null) : array
    {
        $pnbp_bulan_lalu = !isset($month) 

           ? Rupiah::rp($this->pnbpKt($year, $month) + $this->pnbpKh($year, $month))

           : Rupiah::rp($this->pnbpKt($year, $month - 1) + $this->pnbpKh($year, $month - 1));          


    	$data[$year] = [

    		'tahun' => $year,
            'bulan' => $month,
    		'kh' => $this->dataKh($year, $month),
    		'kt' => $this->dataKt($year, $month),
            'pnbp' => [
                'PNBP Karantina Hewan' => Rupiah::rp($this->pnbpKh($year, $month)),
                'PNBP Karantina Tumbuhan' => Rupiah::rp($this->pnbpKt($year, $month)),
                'Total PNBP Bulan Lalu'  => $pnbp_bulan_lalu,
                'Total PNBP Tahun ' . $year => Rupiah::rp($this->pnbpKt($year) + $this->pnbpKh($year))
            ],
    	];

    	return $data[$year];
    }

    public function dataKh($year, $month = null) : array
    {
    	$domas_kh 	= DomasKh::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

    	$dokel_kh 	= DokelKh::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

    	$ekspor_kh 	= EksporKh::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

    	$impor_kh 	= ImporKh::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

        if ($month !== null) {

            $domas_kh->whereMonth('bulan', $month);

            $dokel_kh->whereMonth('bulan', $month);

            $ekspor_kh->whereMonth('bulan', $month);

            $impor_kh->whereMonth('bulan', $month);

        }           

    	$datakh = [

    		'Domestik Masuk Karantina Hewan' => [
    			'frekuensi' => $domas_kh->count(),
    			'link' => route('kh.view.page.domas', $year)
    		],
			'Domestik Keluar Karantina Hewan' => [
				'frekuensi' => $dokel_kh->count(),
				'link' => route('kh.view.page.dokel', $year)
			],
			'Ekspor Karantina Hewan' => [
				'frekuensi' => $ekspor_kh->count(),
				'link' => route('kh.view.page.ekspor', $year)
			],
			'Impor Karantina Hewan' => [
				'frekuensi' => $impor_kh->count(),
				'link' => route('kh.view.page.impor', $year)
			]

    	];

    	return $datakh;
    }

    public function dataKt($year, $month = null) : array
    {

    	$domas_kt   = DomasKt::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

        $dokel_kt   = DokelKt::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

        $ekspor_kt  = EksporKt::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

        $impor_kt   = ImporKt::where('nomor_dok_pelepasan','!=', NULL)
                    ->whereYear('bulan', $year);

        if ($month !== null) {

            $domas_kt->whereMonth('bulan', $month);

            $dokel_kt->whereMonth('bulan', $month);

            $ekspor_kt->whereMonth('bulan', $month);
            
            $impor_kt->whereMonth('bulan', $month);

        }   

    	$datakt = [

    		'Domestik Masuk Karantina Tumbuhan' => [
    			'frekuensi' => $domas_kt->count(),
    			'link' => route('kt.view.page.domas', $year)
    		],
			'Domestik Keluar Karantina Tumbuhan' => [
				'frekuensi' => $dokel_kt->count(),
				'link' => route('kt.view.page.dokel', $year)
			],
			'Ekspor Karantina Tumbuhan' => [
				'frekuensi' => $ekspor_kt->count(),
				'link' => route('kt.view.page.ekspor', $year)
			],
			'Impor Karantina Tumbuhan' => [
				'frekuensi' => $impor_kt->count(),
				'link' => route('kt.view.page.impor', $year)
			]
    	];

    	return $datakt;
    }

    public function pnbpKh($year, $month = null) : int
    {
        $pnbp_domas     = DomasKh::whereYear('bulan', $year);

        $pnbp_dokel     = DokelKh::whereYear('bulan', $year);

        $pnbp_ekspor    = EksporKh::whereYear('bulan', $year);

        $pnbp_impor     = ImporKh::whereYear('bulan', $year);

        if ($month !== null) {

            $pnbp_domas->whereMonth('bulan', $month);

            $pnbp_dokel->whereMonth('bulan', $month);

            $pnbp_ekspor->whereMonth('bulan', $month);

            $pnbp_impor->whereMonth('bulan', $month);

        }

        return $pnbp_domas->sum('total_pnbp') 
                + $pnbp_dokel->sum('total_pnbp') 
                + $pnbp_ekspor->sum('total_pnbp') 
                + $pnbp_impor->sum('total_pnbp');
    }

    public function pnbpKt($year, $month = null) : int
    {
        $pnbp_domas     = DomasKt::whereYear('bulan', $year);

        $pnbp_dokel     = DokelKt::whereYear('bulan', $year);

        $pnbp_ekspor    = EksporKt::whereYear('bulan', $year);

        $pnbp_impor     = ImporKt::whereYear('bulan', $year);

        if ($month !== null) {

            $pnbp_domas->whereMonth('bulan', $month);

            $pnbp_dokel->whereMonth('bulan', $month);

            $pnbp_ekspor->whereMonth('bulan', $month);

            $pnbp_impor->whereMonth('bulan', $month);

        }

        return $pnbp_domas->sum('total_pnbp') 
                + $pnbp_dokel->sum('total_pnbp') 
                + $pnbp_ekspor->sum('total_pnbp') 
                + $pnbp_impor->sum('total_pnbp');

    }

}
