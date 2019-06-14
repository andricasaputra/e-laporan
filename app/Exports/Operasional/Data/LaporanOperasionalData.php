<?php  

namespace App\Exports\Operasional\Data;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LaporanOperasionalData extends AbstractLaporanData
{
  	public function __construct(Request $request, $repository, $permohonan)
  	{
  		parent::__construct($request, $repository, $permohonan);
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
          'bodies'        => $this->getBodyData(),
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
     * Untuk set data utama pada body table laporan
     *
     * @return array
     */
    protected function getBodyData() : Collection
    {
        return $this->model::laporanOperasional([$this->year, $this->month, $this->wilker_id]);
    }

    /**
     * Untuk menyimpan total PNBP sesuai jenis permohonan
     *
     * @return string
     */
    private function mapTotalPnbp()
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
    private function mapTotalVolumeKomoditi()
    {
        return $this->repository->totalVolumePerSatuan()[strtolower($this->permohonan)];
    }

    /**
     * Untuk menyimpan total Volume berdasarkan komoditi sesuai jenis permohonan
     *
     * @return string
     */
    private function mapRekapitulasiKomoditi()
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
    protected function getTableHeader() : array
    {
    	return $this->karantina == 'Kt' ? $this->tableHeaderLaporanOperasionalKt() : $this->tableHeaderLaporanOperasionalKh();
    }
}