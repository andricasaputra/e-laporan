<?php

namespace App\Http\Controllers\Operasional;

use DataTables;
use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\Operasional\LogInfo;
use App\Models\Operasional\DokelKh;
use App\Models\Operasional\DomasKh;
use App\Models\Operasional\ImporKh;
use App\Models\Operasional\EksporKh;
use Illuminate\Support\Facades\Auth;
use App\Events\OperasionalRollbackEvent;

class HomeKh extends BaseOperasional
{
    public function showMenu()
    {
        return view('intern.operasional.kh.menu');
    }

    public function homeUpload(int $year = null, $wilker = null)
    {
        $year           = $year ?? date('Y');

        $all_wilker     = $this->setActiveUserWilker();

        $wilker         = Auth::user()->wilker->first();

        return view('intern.operasional.kh.upload.home_upload')->with(compact('all_wilker', 'wilker' ,'year'));
    }

    public function show($year = null)
    {
        $year = $year ?? date('Y');

        return view('intern.operasional.kh.home')
        ->with('datas', $this->dataOperasional($year));
    }

    public function dataOperasional($year)
    {
    	$data[$year] = [

    		'tahun' => $year,
    		'kh' => $this->datakh($year)
    		
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

    public function logApi(int $year, int $wilker)
    {
        $log = LogInfo::with(['wilker'])->where('wilker_id', $wilker)->whereYear('bulan', $year)
                ->whereIn('type', ['dokel_kh', 'domas_kh', 'ekspor_kh', 'impor_kh'])
                ->orderBy('id', 'desc')->get();

        return Datatables::of($log)->addIndexColumn()
         ->addColumn('action', function ($data) {

            if (empty($data->rolledback_at) || $data->rolledback_at == "") {

               if (\Carbon::now()->subDays(1)->toDateTimeString() > $data->created_at) {

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

        return redirect(route('kh.homeupload'))->with('success', 'Laporan Operasional Berhasil Ditarik Kembali');
    }

}
