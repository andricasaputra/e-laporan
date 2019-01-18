<?php 

namespace App\Repositories\Ikm;

use App\Models\Ikm\Result;
use App\Traits\Repository;
use App\Models\Ikm\Question;
use App\Models\MasterPegawai;
use Spipu\Html2Pdf\Html2Pdf as PDF;
use App\Contracts\RepositoryInterface;

class StatistikRepository implements RepositoryInterface
{
	use Repository;

	/**
     * Untuk menyimpan Nilai Rata - rata (NRR) 
     *
     * @var float
     */
	const NRR = 0.111;

	/**
     * Untuk menyimpan total nilai IKM berdasarkan Periode 
     *
     * @var float
     */
    private $totalNilai;

    /**
     * Untuk menyimpan total responden yang mengikuti survey sesuai periode 
     *
     * @var int
     */
    private $totalResponden;

    /**
     * Untuk Menampilkan API Statistik IKM yang dipilih berdasarkan table result (database)
     *
     * @param int $id
     * @return collections of Datatables 
     */
    public function api($id)
    {
    	return datatables($this->apiSource($id))
    			->addIndexColumn(1)
    			->make(true);
    }

    /**
     * Untuk Set API Statistik IKM yang dipilih berdasarkan table result (database)
     *
     * @param int $id
     * @return collections
     */
    public function apiSource($id)
    {
    	$result = Result::questionGroup($id);

		return $this->mapApi($result);
    }

    /**
     * Source API Statistik IKM yang dipilih berdasarkan table result (database)
     * mangumpulkan semua data (semua method) yang dibutuhkan untuk API menjadi 1
     *
     * @param App\Models\Ikm\Result
     * @return array
     */
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

     /**
     * Menghitung statistik total responden berdasarkan periode
     *
     * @param App\Models\Ikm\Responden
     * @return void
     */
    public function totalResponden($responden)
    {
    	$this->totalResponden = $responden->count();

    	return $this;
    }

    /**
     * Menghitung statistik jumlah nilai IKM berdasarkan periode
     *
     * @param App\Models\Ikm\Responden
     * @return void
     */
    public function totalNilai($responden)
    {
		$this->totalNilai = $responden->map(function($total){

			return $total->answer;

		})->sum('nilai');

    	return $this;
	}

	/**
     * Mendapatkan semua pertanyaan & jawaban per Responden
     *
     * @param App\Models\Ikm\Responden
     * @return collections
     */
	public function allQuestions($responden)
    {
		return $responden->map(function($question){

			return $question->question->question;

		})->first();
	}

	/**
     * Mendapatkan setiap unsur pelayanan dari pertanyaan 
     * masing - masing responden
     * Note : Setiap pertanyaan mewakili 1 Unsur Pelayanan
     *
     * @param App\Models\Ikm\Responden
     * @return collections
     */
	public function unsurPelayanan($responden)
    {
		return $responden->map(function($question){

			return $this->getUnsur((int) $question->question_id);

		})->first();
	}

	/**
     * Mendapatkan keterangan periode Survey IKM yang diikuti oleh 
     * masing - masing responden
     *
     * @param App\Models\Ikm\Responden
     * @return collections
     */
	public function keterangan($responden)
	{
		return $responden->map(function($keterangan){

			return $keterangan->ikm->keterangan;

		})->first();
	}

	/**
     * Menghitung rata - rata NRR
     *
     * @param int $total
     * @return float
     */
	public function rataRataNrr($total)
	{
		return number_format((float) $total / $this->totalResponden, 3, '.', '');	
	}

	/**
     * Menghitung rata - rata NRR per unsur layanan
     *
     * @param int $total
     * @return float
     */
	public function rataRataPerUnsurPelayanan($total)
	{
		return number_format((float) $total / $this->totalResponden * self::NRR, 3, '.', '');	
	}

	/**
     * Set IKM Periode Default juga tidak ada periode yang dipilih
     *
     * @return int ID of IKM
     */
    public function default()
    {
    	$id 	= 	Result::with(['ikm' => function ($query) { 

			    		$query->whereIsOpen(1); 
			    		
			    	}])->first();

        if (is_null($id)) return 1;

        if (is_null($id->ikm))  return 1;

        return $id->ikm->id;
	}

	/**
     * Set unsur pelayanan berdasarkan jawaban
     *
     * @return int $no
     */
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

	/**
     * Untuk Cetak PDF Rekapitulasi IKM
     *
     * @return collections
     */
	public function cetakRekap(int $id)
    {
    	$datas = [

    		'table_header' 	=> $this->setCetakTableHeader(),

    		'table_body' 	=> [

    			'nilai' 	=> $this->setCetakTableBody($id),
    			'nrr' 		=> $this->apiSource($id),
    			'kepala' 	=> MasterPegawai::whereJabatanId(1)->first()
    		]

    	];

    	return collect($datas)->map(function($result){

			return (object) $result;

		});
    }

    /**
     * Untuk Cetak PDF Rekapitulasi IKM (Set Table Header)
     *
     * @return collections
     */
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

    /**
     * Untuk Cetak PDF Rekapitulasi IKM (Set Table Body)
     *
     * @return collections
     */
    public function setCetakTableBody(int $id)
    {
    	$result    = Result::respondenGroup($id);

    	return $result->map(function($item){

    		return $item;

    	})->all();
    }

}