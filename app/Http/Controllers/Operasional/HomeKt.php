<?php

namespace App\Http\Controllers\Operasional;

use DataTables;
use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\Operasional\LogInfo;
use App\Models\Operasional\DokelKt;
use App\Models\Operasional\DomasKt;
use App\Models\Operasional\ImporKt;
use App\Models\Operasional\EksporKt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\OperasionalRollbackEvent;

class HomeKt extends BaseOperasional
{
    public function showMenu()
    {
        return view('intern.operasional.kt.menu');
    }

    public function homeUpload(int $year = null)
    {
        $year           = $year ?? date('Y');

        $all_wilker     = $this->setActiveUserWilker();

        $wilker         = Auth::user()->wilker->first();

        return view('intern.operasional.kt.upload.home_upload')->with(compact('all_wilker', 'wilker' ,'year'));
    }

    public function show($year = null)
    {
        $year = $year ?? date('Y');

        return view('intern.operasional.kt.home')
        ->with('datas', $this->dataOperasional($year));
    }

    public function dataOperasional($year)
    {
    	$data[$year] = [

    		'tahun' => $year,
    		'kt' => $this->dataKt($year)
    		
    	];

    	return $data[$year];
    }

    public function dataKt($year)
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

    public function logApi(int $year, int $wilker)
    {
        $log = LogInfo::with(['wilker'])->where('wilker_id', $wilker)->whereYear('bulan', $year)
                ->whereIn('type', ['dokel_kt', 'domas_kt', 'ekspor_kt', 'impor_kt'])
                ->orderBy('id', 'desc')->get();

        return Datatables::of($log)->addIndexColumn()
         ->addColumn('action', function ($data) {

            if (empty($data->rolledback_at) || $data->rolledback_at == "") {

                if (\Carbon::now()->subDays(1) > $data->created_at) {

                    $action = 'No action available';
                    
                }else{

                    $action = '<a href="#" data-id = "'.$data->id.'" class="btn btn-danger" id="rollbackOperasionalBtn">
                            <i class="fa fa-repeat fa-fw"></i> Rollback
                        </a>';
                }       

            }else{

               $action = 'No action available';

            }

            return $action;


        })->make(true);

    }

    public function destroy(Request $request)
    {
        $log = LogInfo::find($request->id);

        event(new OperasionalRollbackEvent($log));

        $log->update([

            "status" => 1,
            "rolledback_at" => \Carbon::now()

        ]);

        return redirect(route('kt.homeupload'))->with('success', 'Laporan Operasional Berhasil Ditarik Kembali');
    }

}
