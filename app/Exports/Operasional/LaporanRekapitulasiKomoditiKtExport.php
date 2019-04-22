<?php

namespace App\Exports\Operasional;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Operasional\Factories\SheetFactory;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

class LaporanRekapitulasiKomoditiKtExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * Menyimpan Instance dari request
     *
     * @var Illuminate\Http\Request $request
     */
    public $request;

    /**
     * Menyimpan Instance repository yang dipakai
     *
     * @var App\Repositories\Operasional\DataOperasionalKhRepository|DataOperasionalKtRepository
     */
    public $repository;

    /**
    * Untuk Menyimpan pilihan semua jenis permohonan laporan
    *
    * @var array
    */
    protected $all = ['Dokel', 'Domas', 'Ekspor', 'Impor', 'Reekspor', 'SerahTerima'];

    /**
    * Untuk Menyimpan multi jenis permohonan yang akan didownload oleh user
    *
    * @var array
    */
    protected $type;

    /**
    * Set property awal
    *
    * @param Illuminate\Http\Request $request
    * @return void
    */
    public function __construct(Request $request)
    {
        $this->request    = $request;

        $this->repository = new Repository($request);

        $this->type       = $this->getPermohonanType($request->type);
    }

    /**
     * @return array
     */
    public function sheets() : array
    {
        $sheets = [];

        foreach ($this->type as $permohonan) {

          $sheets[] = (new SheetFactory)->initSheet($this->request, $this->repository, $permohonan);

        }

        return $sheets;
    }

    /**
     * Untuk mendapatkan tipe permohonan
     *
     * @param string $type
     * @return string|array
     */
    protected function getPermohonanType($type) : array
    {
        return $type == 'all' ? $this->all : [$type];
    }

}
