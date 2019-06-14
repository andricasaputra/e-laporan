<?php 

namespace App\Exports\Operasional\Data;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use Illuminate\Support\Collection;
use App\Traits\Operasional\TableOperasionalHeader;

abstract class AbstractLaporanData
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
     * Untuk mendapatkan pejabat penandatangan laporan
     *
     * @return array
     */
    protected function getSignatory()
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

    abstract public function sentDatasToView(): array;

    abstract protected function getBodyData(): Collection;

    abstract public function getTotalData(): int;

    abstract protected function getTableHeader(): array;
}