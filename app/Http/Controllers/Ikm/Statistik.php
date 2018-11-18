<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Result;
use App\Models\Ikm\Responden;
use App\Models\Ikm\Question;
use App\Models\Ikm\Answer;
use App\Models\Ikm\Jadwal;
use App\Models\MasterPegawai;
use DataTables;
use PDF;

class Statistik extends Controller
{
    public function api(int $id = null)
    {
    	if (!isset($id)) {

			$id = $this->getId();
		}

    	return Datatables::of($this->apiSource($id))->addIndexColumn(1)->make(true);
    }

    public function index(int $id = null)
    {
    	if(!isset($id)){
    		$id = $this->getId();
    	}

    	$questions =  Question::all();
    	$ikm = Jadwal::select('id', 'keterangan')->get();
    	$ikm_ket = Jadwal::select('keterangan')->whereId($id)->first();
    	return view('intern.ikm.statistik.index')
    	->with('result', $this->getRataRataNilai())
    	->with('questions', $questions)
    	->with('ikm', $ikm)
    	->with('ikm_ket', $ikm_ket)
    	->with('id', $id);
    }

    public function cetakRekap(int $id)
    {
    	if(!isset($id)){

    		$id = $this->getId();
    	}

    	$datas = [

    		'table_header' => $this->setCetakTableHeader(),
    		'table_body' => [
    			'nilai' => $this->setCetakTableBody($id),
    			'nrr' => $this->apiSource($id),
    			'kepala' => MasterPegawai::whereJabatanId(1)->first()
    		]

    	];

    	$datas = collect($datas)->map(function($result){
			return (object) $result;
		});

    	$pdf = PDF::loadView('intern.ikm.statistik.cetak', compact('datas'));
		return $pdf->stream('ikm.pdf');
    }

    private function setCetakTableHeader()
    {
    	$questions = Question::all();

    	$data = [];

    	$data[] = 'No Responden';

    	$no = 1;

    	foreach ($questions as $question) {
    		$data[] = 'U'.$no++;
    	}

    	return $data;
    }

    private function setCetakTableBody(int $id)
    {
    	$result = Result::with(['answer:ikm_answer.id,nilai'])->where('ikm_id', $id)->get();

    	$result = $result->groupBy('responden_id');

    	$data = [];

    	foreach ($result as $res) {

    		$data[] = $res;

    	}

    	return $data;
    }

    private function apiSource(int $id = null)
    {
		if (!isset($id)) {

			$id = $this->getId();
		}
    		
    	$result = Result::with(['answer:ikm_answer.id,nilai', 'question'])->where('ikm_id', $id)->get();

    	$result = $result->groupBy('question_id');

    	$data = [];

    	$no = 1;

    	$no2 = 1;
    	
    	foreach($result as $res):

    		$nrr = $res->sum('answer.nilai');

    		$total_responden = $res->count();

			foreach($res->take(1) as $r):

			 	$data[] = [

			 		'total_responden' => $total_responden,
		  			'questions' => $r->question->question,
		  			'unsur_pelayanan' => 'U'.$no++.' - '.$this->getUnsur($no2++),
		  			'nrr' => $nrr ,
		  			'rata_nrr' => number_format((float)$nrr  / $total_responden, 3, '.', ''),
		  			'nrr_perunsur' => number_format((float)$nrr  / $total_responden * 0.111, 3, '.', '')

	  			];

			endforeach;	

  		endforeach;

  		return $data;
    }

    private function getRataRataNilai()
    {
    	$result = Result::with(['answer:ikm_answer.id,nilai', 'question'])->get();

    	return $result->groupBy('question_id');
    }

    private function getId()
    {
    	$result_id = Result::with(['ikm' => function ($query) {
	    	$query->where('is_open', 1);
		}])->first();

		$id = $result_id->ikm->id;

		return $id;
	}

	private function getUnsur(int $no)
	{
		switch ($no) {
			case 1:
				$unsur_pelayanan = 'Persyaratan';
				break;
			case 2:
				$unsur_pelayanan = 'Prosedur';
				break;
			case 3:
				$unsur_pelayanan = 'Waktu Pelayanan';
				break;
			case 4:
				$unsur_pelayanan = 'Biaya/tarif';
				break;
			case 5:
				$unsur_pelayanan = 'Produk layanan';
				break;
			case 6:
				$unsur_pelayanan = 'Kompetensi pelaksana';
				break;
			case 7:
				$unsur_pelayanan = 'Perilaku pelaksana';
				break;
			case 8:
				$unsur_pelayanan = 'Penanganan pengaduan, saran dan masukan';
				break;
			default:
				$unsur_pelayanan = 'Sarana dan prasarana';
				break;
		}

		return $unsur_pelayanan;
	}

}
