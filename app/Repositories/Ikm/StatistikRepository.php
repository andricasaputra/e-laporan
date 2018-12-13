<?php 

namespace App\Repositories\Ikm;

use DataTables;
use Barryvdh\DomPDF\PDF;
use App\Models\Ikm\Result;
use App\Traits\Repository;
use App\Models\Ikm\Question;
use App\Models\MasterPegawai;
use App\Contracts\RepositoryInterface;

class StatistikRepository implements RepositoryInterface
{
	use Repository;

	const NRR = 0.111;
    private $totalNilai;
    private $totalResponden;

    public function api($id)
    {
    	return Datatables::of($this->apiSource($id))->addIndexColumn(1)->make(true);
    }

    public function apiSource($id)
    {
    	$result = Result::questionGroup($id);

		return $this->mapApi($result);
    }

    public function mapApi($result)
    {
    	return $result->map(function($responden){

		 	$data = [];

    		$data['totalResponden'] 			= $this->totalResponden($responden)->totalResponden;

    		$data['totalNilai']  				=  $this->totalNilai($responden)->totalNilai;

			$data['allQuestions'] 				= $this->allQuestions($responden);

			$data['unsurPelayanan'] 			= $this->unsurPelayanan($responden);

    		$data['keterangan'] 				= $this->keterangan($responden);

    		$data['rataRataNrr'] 				= $this->rataRataNrr($this->totalNilai);

			$data['rataRataPerUnsurPelayanan'] 	= $this->rataRataPerUnsurPelayanan($this->totalNilai);
    		
    		return $data;

		});
    }

    public function totalResponden($responden)
    {
    	$this->totalResponden = $responden->count();

    	return $this;
    }

    public function totalNilai($responden)
    {
		$this->totalNilai = $responden->map(function($total){

			return $total->answer;

		})->sum('nilai');

    	return $this;
	}

	public function allQuestions($responden)
    {
		return $responden->map(function($question){

			return $question->question->question;

		})->first();
	}

	public function unsurPelayanan($responden)
    {
		return $responden->map(function($question){

			return $this->getUnsur((int) $question->question_id);

		})->first();
	}

	public function keterangan($responden)
	{
		return $responden->map(function($keterangan){

			return $keterangan->ikm->keterangan;

		})->first();
	}

	public function rataRataNrr($total)
	{
		return number_format((float) $total / $this->totalResponden, 3, '.', '');	
	}

	public function rataRataPerUnsurPelayanan($total)
	{
		return number_format((float) $total / $this->totalResponden * self::NRR, 3, '.', '');	
	}

    public function default()
    {
    	$id = Result::with(['ikm' => function ($query) { $query->where('is_open', 1); }])->first();

        if (is_null($id)) return 1;

        if (is_null($id->ikm))  return 1;

        return $id->ikm->id;
	}

	public function getUnsur(int $no)
	{
		switch ($no) {
			case 1:
				$unsur_pelayanan = "U{$no} Persyaratan";
				break;
			case 2:
				$unsur_pelayanan = "U{$no} Prosedur";
				break;
			case 3:
				$unsur_pelayanan = "U{$no} Waktu Pelayanan";
				break;
			case 4:
				$unsur_pelayanan = "U{$no} Biaya/tarif";
				break;
			case 5:
				$unsur_pelayanan = "U{$no} Produk layanan";
				break;
			case 6:
				$unsur_pelayanan = "U{$no} Kompetensi pelaksana";
				break;
			case 7:
				$unsur_pelayanan = "U{$no} Perilaku pelaksana";
				break;
			case 8:
				$unsur_pelayanan = "U{$no} Penanganan pengaduan, saran dan masukan";
				break;
			default:
				$unsur_pelayanan = "U{$no} Sarana dan prasarana";
				break;
		}

		return $unsur_pelayanan;
	}

	public function cetakRekap(int $id)
    {
    	$datas = [

    		'table_header' => $this->setCetakTableHeader(),
    		'table_body' => [

    			'nilai' => $this->setCetakTableBody($id),
    			'nrr' => $this->apiSource($id),
    			'kepala' => MasterPegawai::whereJabatanId(1)->first()
    		]

    	];

    	return collect($datas)->map(function($result){

			return (object) $result;

		});
    }

    public function setCetakTableHeader()
    {
    	$questions     = Question::all();

    	$data[]        = 'No Responden';

    	$no            = 1;

    	foreach ($questions as $question) {

    		$data[] = "U" . $no++;

    	}

    	return $data;
    }

    public function setCetakTableBody(int $id)
    {
    	$result    = Result::respondenGroup($id);

    	return $result->map(function($item){

    		return $item;

    	})->all();
    }

}