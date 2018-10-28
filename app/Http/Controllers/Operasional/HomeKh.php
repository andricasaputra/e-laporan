<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Operasional\DokelKh;
use App\Models\Operasional\DomasKh;
use App\Models\Operasional\EksporKh;
use App\Models\Operasional\ImporKh;

class HomeKh extends Controller
{
    public function show(Request $request)
    {
    	if(!isset($request)) {

		   $year = date('Y');

		}else{

			return redirect(route('showyear.operasional.kh', $request->year));
		}

    	return view('operasional.kh.home')
    	->with('datas', $this->dataOperasional($year));
    }


    public function showAnotherYear($year = null)
    {
    	return view('operasional.kh.home')
    	->with('datas', $this->dataOperasional($year));
    }


    public function dataOperasional($year)
    {
    	if(!isset($year)) {

		   $year = date('Y');

		}

    	$data[$year] = [

    		'tahun' => $year,
    		'kh' => $this->datakh($year)
    		
    	];

    	return $data[$year];
    }

    public function dataKh($year )
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

}
