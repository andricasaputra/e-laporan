<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Operasional\DokelKh;
use App\Models\Operasional\DomasKh;
use App\Models\Operasional\EksporKh;
use App\Models\Operasional\ImporKh;
use App\Models\Operasional\DokelKt;
use App\Models\Operasional\DomasKt;
use App\Models\Operasional\EksporKt;
use App\Models\Operasional\ImporKt;

class HomeAdmin extends Controller
{
    public function show(Request $request)
    {
    	if(!isset($request)) {

		   $year = date('Y');

		}else{

			return redirect(route('showyear.operasional', $request->year));
		}

    	return view('intern.operasional.home')
    	->with('datas', $this->dataOperasional($year));
    }


    public function showAnotherYear($year = null)
    {
    	return view('intern.operasional.home')
    	->with('datas', $this->dataOperasional($year));
    }


    public function dataOperasional($year)
    {
    	if(!isset($year)) {

		   $year = date('Y');

		}

    	$data[$year] = [

    		'tahun' => $year,
    		'kh' => $this->dataKh($year),
    		'kt' => $this->dataKt($year)
    		
    	];

    	return $data[$year];
    }

    public function dataKh($year)
    {

    	$domas_kh 	= DomasKh::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
    	$dokel_kh 	= DokelKh::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
    	$ekspor_kh 	= EksporKh::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
    	$impor_kh 	= ImporKh::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();

    	$datakh = [

    		'Domestik Masuk Karantina Hewan' => [
    			'frekuensi' => $domas_kh,
    			'link' => route('kh.view.page.domas', $year)
    		],
			'Domestik Keluar Karantina Hewan' => [
				'frekuensi' => $dokel_kh,
				'link' => route('kh.view.page.dokel', $year)
			],
			'Ekspor Karantina Hewan' => [
				'frekuensi' => $ekspor_kh,
				'link' => route('kh.view.page.ekspor', $year)
			],
			'Impor Karantina Hewan' => [
				'frekuensi' => $impor_kh,
				'link' => route('kh.view.page.impor', $year)
			]
    	];

    	return $datakh;
    }

    public function dataKt($year )
    {

    	$domas_kt   = DomasKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
        $dokel_kt   = DokelKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
        $ekspor_kt  = EksporKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
        $impor_kt   = ImporKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();

    	$datakt = [

    		'Domestik Masuk Karantina Tumbuhan' => [
    			'frekuensi' => $domas_kt,
    			'link' => route('kt.view.page.domas', $year)
    		],
			'Domestik Keluar Karantina Tumbuhan' => [
				'frekuensi' => $dokel_kt,
				'link' => route('kt.view.page.dokel', $year)
			],
			'Ekspor Karantina Tumbuhan' => [
				'frekuensi' => $ekspor_kt,
				'link' => route('kt.view.page.ekspor', $year)
			],
			'Impor Karantina Tumbuhan' => [
				'frekuensi' => $impor_kt,
				'link' => route('kt.view.page.impor', $year)
			]
    	];

    	return $datakt;
    }

}
