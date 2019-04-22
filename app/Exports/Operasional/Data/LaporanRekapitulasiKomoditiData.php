<?php  

namespace App\Exports\Operasional\Data;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use App\Traits\Operasional\TableOperasionalHeader;

class LaporanRekapitulasiKomoditiData
{
	use TableOperasionalHeader;

	/**
     * Menyimpan Instance repository yang dipakai
     *
     * @var App\Repositories\Operasional\DataOperasionalKhRepository|DataOperasionalKtRepository
     */
    protected $repository;

    /**
    * Untuk Menyimpan tahun laporan
    *
    * @var int
    */
    protected $year;

    /**
    * Untuk Menyimpan bulan laporan
    *
    * @var string
    */
    protected $month;

    /**
    * Untuk Menyimpan wilker laporan
    *
    * @var string
    */
    protected $wilker_id;

    /**
    * Untuk Menyimpan jenis karantina laporan
    *
    * @var string
    */
    protected $karantina;

    /**
    * Untuk Menyimpan id penandatangan laporan
    *
    * @var int
    */
    protected $signatory;

    /**
    * Untuk Menyimpan namespace model yang akan dipakai
    *
    * @var string
    */
    protected $modelNamespace = 'App\\Models\\Operasional\\';

    /**
    * Untuk Menyimpan nama class dari model
    *
    * @var string
    */
    protected $model;

    /**
    * Untuk Menyimpan nama kolom kh yang diambil dari database
    *
    * @var array
    */
    protected $mapColumnKh = [
        'nama' => 'nama_mp',
        'volume' => 'jumlah',
        'satuan' => 'satuan'
    ];

    /**
    * Untuk Menyimpan nama kolom kt yang diambil dari database
    *
    * @var array
    */
    protected $mapColumnKt = [
        'nama' => 'nama_komoditas',
        'volume' => 'volume_netto',
        'satuan' => 'sat_netto'
    ];

    /**
    * Untuk Menyimpan single jenis permohonan laporan
    *
    * @var string
    */
    public $permohonan;

	public function __construct(Request $request, $repository, $permohonan)
	{
		$this->repository  = $repository;

        $this->permohonan  = $permohonan;

		$this->year 	   = $request->year;

    	$this->month 	   = $request->month;

    	$this->wilker_id   = $request->wilker_id;

    	$this->signatory   = $request->signatory;

    	$this->karantina   = $request->karantina;

        $this->model       = $this->modelNamespace . $permohonan . ucfirst($this->karantina);
	}

	/**
     * Untuk populasi data yang akan dikirim ke view excel 
     *
     * @return array
     */
    public function sentDatasToView() : array
    {
        return [

            'headers'    => $this->getTableHeader(),
            'bodies'     => $this->setBodyData(),
            'permohonan' => $this->getPermohonanFullName(),
            'tahun'      => $this->getYear(),
            'bulan'      => $this->getMonthName(),
            'wilker'     => $this->getWilkerName(),
            'signatory'  => $this->getSignatory(),

        ];
    }

    /**
     * Untuk set data utama pada body table laporan
     *
     * @return array
     */
    protected function setBodyData()
    {
        /*get data*/
        $query =  $this->model::laporanRekapitulasiKomoditi([$this->year, $this->month, $this->wilker_id]);

        return  $query->groupBy('wilker_id')->map(function($data){

            return $data->groupBy($this->getColumn('nama'))->map(function($subdata) use ($data){

                return [

                    'wilker'      => $subdata->first()->wilker->nama_wilker,
                    'volume'      => $subdata->sum($this->getColumn('volume')), 
                    'frekuensi'   => $subdata->count(),
                    'satuan'      => $subdata->pluck($this->getColumn('satuan'))->flatten(1)->first(),
                    'kota_asal'   => $subdata->groupBy('kota_asal'),
                    'kota_tuju'   => $subdata->groupBy('kota_tuju'),
                    'negara_asal' => $subdata->groupBy('asal'),
                    'negara_tuju' => $subdata->groupBy('tujuan'),
                ];

            });

        });
    }

     /**
     * Untuk menghitung total data yang akan ditampilkan pada laporan
     *
     * @return int
     */
    public function getTotalData() : int
    {
        $query = $this->model::laporanRekapitulasiKomoditi([$this->year, $this->month, $this->wilker_id]);

        return $query->groupBy('wilker_id')->map(function($data){

            return $data->groupBy($this->getColumn('nama'))->map(function($subdata) use ($data){

                return [

                    'wilker'      => $subdata->first()->wilker->nama_wilker,
                    'volume'      => $subdata->sum($this->getColumn('volume')), 
                    'frekuensi'   => $subdata->count(),
                    'satuan'      => $subdata->pluck($this->getColumn('satuan'))->flatten(1)->first(),
                    'kota_asal'   => $subdata->groupBy('kota_asal'),
                    'kota_tuju'   => $subdata->groupBy('kota_tuju'),
                    'negara_asal' => $subdata->groupBy('asal'),
                    'negara_tuju' => $subdata->groupBy('tujuan'),
                ];

            })->count();

        })->sum();
    }

    /**
     * Untuk mendapatkan nama kolom dalam database secara dinamis antara KH dan KT
     *
     * @param string $selectColumn
     * @return string
     */
    private function getColumn(string $selectColumn) : string
    {
        $useArray = $this->karantina == 'Kt' ? $this->mapColumnKt : $this->mapColumnKh;

        return $useArray[$selectColumn];
    }

    /**
     * Untuk mendapatkan tabel header yang akan dipakai sesuai dengan jenis karantina
     *
     * @return array
     */
    public function getTableHeader() : array
    {
    	return $this->karantina == 'Kt' ? $this->tableHeaderLaporanRekapitulasiKomoditiKt() 
                                        : $this->tableHeaderLaporanRekapitulasiKomoditiKh();
    }

    /**
     * Untuk mendapatkan pejabat penandatangan laporan
     *
     * @return array
     */
    public function getSignatory()
    {
        return MasterPegawai::with('jabatan')->find($this->signatory);
    }

    /**
     * Untuk mendapatkan tahun
     *
     * @return string
     */
    protected function getYear()
    {
        return $this->year ?? date('Y');
    }

    /**
     * Untuk mendapatkan nama bulan
     *
     * @return string
     */
    protected function getMonthName()
    {
        return $this->month == 'all' ? '' : bulan($this->month);
    }

    /**
     * Untuk mendapatkan nama wilker
     *
     * @return string
     */
    protected function getWilkerName()
    {
        $wilker = $this->wilker_id;

        return (! isset($wilker)) ? Wilker::find(1)->nama_wilker : Wilker::find($wilker)->nama_wilker;
    }

    /**
    * Untuk mendapatkan Fullname jenis laporan, 
    * Ex : Dokel => Domestik Keluar
    *
    * @return string
    */
    protected function getPermohonanFullName()
    {
        return $this->model::getPermohonanFullName(strtolower($this->permohonan));
    }
}