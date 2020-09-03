<?php  

namespace App\Exports\Operasional\Data;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LaporanRekapitulasiKomoditiData extends AbstractLaporanData
{
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

            'headers'    => $this->getTableHeader(),
            'bodies'     => $this->getBodyData(),
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
    protected function getBodyData(): Collection
    {
        /*get data*/
        $query =  $this->model::laporanRekapitulasiKomoditi([$this->year, $this->month, $this->wilker_id]);

        return  $query->groupBy('wilker_id')->map(function($data){

            return $data->groupBy($this->getColumn('nama'))->map(function($subdata){

                return [

                    'wilker'      => $subdata->first()->wilker->nama_wilker,
                    
                    'volume'      => collect($subdata->sum($this->getColumn('volume')))->map(function($val, $k){

                        // $val = number_format($val, 3, ',', '.');

                        // $ex = explode(',', $val);

                        // if (end($ex) == 000) {
                        //   $val = $ex[0];
                        // }

                        return $val;

                    }),  
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
    protected function getTableHeader() : array
    {
        return $this->karantina == 'Kt' ? $this->tableHeaderLaporanRekapitulasiKomoditiKt() 
                                        : $this->tableHeaderLaporanRekapitulasiKomoditiKh();
    }
}