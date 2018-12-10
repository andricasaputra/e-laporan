<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Ikm;

use PDF;
use DataTables;
use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Result;
use Illuminate\Http\Request;
use App\Models\Ikm\Question;
use App\Models\MasterPegawai;
use App\Http\Controllers\Controller;

class Statistik extends Controller
{
    const NRR = 0.111;
    protected $total_nrr, $total_responden;

    public function api(int $id = null)
    {
    	$id = $id ?? $this->getId();

    	return Datatables::of($this->apiSource($id))->addIndexColumn(1)->make(true);
    }

    public function index(int $id = null)
    {
    	$id        = $id ?? $this->getId();

    	$questions =  Question::all();

    	$ikm       = Jadwal::select('id', 'keterangan')->get();

    	$ikm_ket   = Jadwal::select('keterangan')->whereId($id)->first();

    	return view('intern.ikm.statistik.index')
    	           ->with('result', $this->getRataRataNilai())
    	           ->with('questions', $questions)
    	           ->with('ikm', $ikm)
    	           ->with('ikm_ket', $ikm_ket)
    	           ->with('id', $id);
    }

    public function cetakRekap(int $id)
    {
    	$id    = $id ?? $this->getId();

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

    protected function setCetakTableHeader() : array
    {
    	$questions     = Question::all();

    	$data          = [];

    	$data[]        = 'No Responden';

    	$no            = 1;

    	foreach ($questions as $question) {

    		$data[] = 'U'.$no++;

    	}

    	return $data;
    }

    protected function setCetakTableBody(int $id) : array
    {
    	$result    = Result::with(['answer:ikm_answer.id,nilai'])->where('ikm_id', $id)->get();

    	$result    = $result->groupBy('responden_id');

    	$data      = [];

    	foreach ($result as $res) {

    		$data[] = $res;

    	}

    	return $data;
    }

    protected function apiSource(int $id = null) : array
    {
		$id       = $id ?? $this->getId();
    		
    	$result   = Result::with(['answer:ikm_answer.id,nilai', 'question', 'ikm'])->where('ikm_id', $id)->get();

    	$result   = $result->groupBy('question_id');

    	$data     = [];

    	$no       = 1;

    	$no2      = 1;
    	
    	foreach($result as $res):

    		$this->total_nrr = $res->sum('answer.nilai');

    		$this->total_responden = $res->count();

			foreach($res->take(1) as $r):

			 	$data[] = [

			 		'total_responden' => $this->total_responden,
		  			'questions' => $r->question->question,
		  			'unsur_pelayanan' => 'U'.$no++.' - '.$this->getUnsur($no2++),
		  			'nrr' => $this->total_nrr ,
		  			'rata_nrr' => number_format((float) $this->total_nrr  / $this->total_responden, 3, '.', ''),
		  			'nrr_perunsur' => number_format((float) $this->total_nrr  / $this->total_responden * self::NRR , 3, '.', ''),
                    'periode' => $r->ikm->keterangan,

	  			];

			endforeach;	

  		endforeach;

  		return $data;
    }

    protected function getRataRataNilai()
    {
    	$result = Result::with(['answer:ikm_answer.id,nilai', 'question'])->get();

    	return $result->groupBy('question_id');
    }

    protected function getId() : int
    {
    	$result_id     =   Result::with(['ikm' => function ($query) {
            
                                $query->where('is_open', 1);
                            
                            }])->first();

        if (is_null($result_id)) return 1;

        if (is_null($result_id->ikm))  return 1;

        return $result_id->ikm->id;
	}

	protected function getUnsur(int $no) : string
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
