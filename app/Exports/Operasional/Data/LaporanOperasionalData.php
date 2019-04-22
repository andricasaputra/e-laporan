<?php  

namespace App\Exports\Operasional\Data;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use App\Traits\Operasional\TableOperasionalHeader;

class LaporanOperasionalData
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

          'headers'       => $this->getTableHeader(),
          'bodies'        => $this->model::laporanOperasional([$this->year, $this->month, $this->wilker_id]),
          'permohonan'    => $this->getPermohonanFullName(),
          'tahun'         => $this->getYear(),
          'bulan'         => $this->getMonthName(),
          'wilker'        => $this->getWilkerName(),
          'signatory'     => $this->getSignatory(),
          'totalPnbp'     => $this->mapTotalPnbp(),
          'totalVolume'   => $this->mapTotalVolumeKomoditi(),
          'volumeKomoditi'=> $this->mapRekapitulasiKomoditi(),

        ];
    }

    /**
     * Untuk menyimpan total PNBP sesuai jenis permohonan
     *
     * @return string
     */
    public function mapTotalPnbp()
    {
        $pnbp = [

          'dokel'       => $this->repository->totalPnbp()->pnbpDokel,
          'domas'       => $this->repository->totalPnbp()->pnbpDomas,
          'ekspor'      => $this->repository->totalPnbp()->pnbpEkspor,
          'impor'       => $this->repository->totalPnbp()->pnbpImpor,
          'serahterima' => $this->repository->totalPnbp()->pnbpSerahTerima,
          'reekspor'    => $this->repository->totalPnbp()->pnbpReekspor,

        ];

        return rp($pnbp[strtolower($this->permohonan)]);
    }

    /**
     * Untuk menyimpan total Volume keseluruhan sesuai jenis permohonan
     *
     * @return string
     */
    public function mapTotalVolumeKomoditi()
    {
        return $this->repository->totalVolumePerSatuan()[strtolower($this->permohonan)];
    }

    /**
     * Untuk menyimpan total Volume berdasarkan komoditi sesuai jenis permohonan
     *
     * @return string
     */
    public function mapRekapitulasiKomoditi()
    {
        $volume = [

          'dokel'       => $this->repository->totalRekapitulasi()->dokelTotalVolume,
          'domas'       => $this->repository->totalRekapitulasi()->domasTotalVolume,
          'ekspor'      => $this->repository->totalRekapitulasi()->eksporTotalVolume,
          'impor'       => $this->repository->totalRekapitulasi()->imporTotalVolume,
          'serahterima' => $this->repository->totalRekapitulasi()->serahTerimaTotalVolume,
          'reekspor'    => $this->repository->totalRekapitulasi()->reeksporTotalVolume,

        ];

        return $volume[strtolower($this->permohonan)];
    }

     /**
     * Untuk menghitung total data yang akan ditampilkan pada laporan
     *
     * @return int
     */
    public function getTotalData() : int
    {
    	return count($this->sentDatasToView()['bodies']);
    }

    /**
     * Untuk menghitung total data rekapitulasi komoditas yang terdapat pada bagian keterangan laporan
     *
     * @return int
     */
    public function getTotalKetData() : int
    {
    	return count($this->mapRekapitulasiKomoditi());
    }

    /**
     * Untuk mendapatkan tabel header yang akan dipakai sesuai dengan jenis karantina
     *
     * @return array
     */
    public function getTableHeader() : array
    {
    	return $this->karantina == 'Kt' ? $this->tableHeaderLaporanOperasionalKt() : $this->tableHeaderLaporanOperasionalKh();
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