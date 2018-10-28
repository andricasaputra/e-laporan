<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Operasional\DokelKt;
use App\Models\Operasional\DomasKt;
use App\Models\Operasional\EksporKt;
use App\Models\Operasional\ImporKt;

class HomeKt extends Controller
{
    public function show(Request $request)
    {
    	if(!isset($request)) {

		   $year = date('Y');

		}else{

			return redirect(route('showyear.operasional.kt', $request->year));
		}

    	return view('operasional.kt.home')
    	->with('datas', $this->dataOperasional($year));
    }


    public function showAnotherYear($year = null)
    {
    	return view('operasional.kt.home')
    	->with('datas', $this->dataOperasional($year));
    }


    public function dataOperasional($year)
    {
    	if(!isset($year)) {

		   $year = date('Y');

		}

    	$data[$year] = [

    		'tahun' => $year,
    		'kt' => $this->dataKt($year)
    		
    	];

    	return $data[$year];
    }

    public function dataKt($year )
    {

    	$domas_kt 	= DomasKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
    	$dokel_kt 	= DokelKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
    	$ekspor_kt 	= EksporKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();
    	$impor_kt 	= ImporKt::where('nomor_dok_pelepasan','!=', NULL)->whereYear('bulan', $year)->count();

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
