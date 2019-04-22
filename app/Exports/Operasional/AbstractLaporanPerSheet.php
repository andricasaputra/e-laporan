<?php

namespace App\Exports\Operasional;

use Illuminate\Http\Request;
use App\Exports\Operasional\Factories\DataFactory;
use App\Exports\Operasional\Data\LaporanOperasionalData;

abstract class AbstractLaporanPerSheet
{
    /**
     * Menyimpan Instance dari request
     *
     * @var Illuminate\Http\Request $request
     */
    protected $request;

    /**
     * Menyimpan Instance dari App\Exports\Operasional\Data\LaporanOperasionalData
     *
     * @var App\Exports\Operasional\Data\LaporanOperasionalData $data
     */
    protected $data;

    /**
     * Menyimpan total data dari isi laporan
     *
     * @var int
     */
    protected $totalData;

    /**
     * Menyimpan total data dari footer laporan
     *
     * @var int
     */
    protected $totalKetData;

    /**
    * Set property awal
    *
    * @param Illuminate\Http\Request $request
    * @param App\Repositories\Operasional\DataOperasionalKhRepository|DataOperasionalKhRepository $repository
    * @param string $permohonan
    * @return void
    */
    protected function __construct(Request $request, $repository, $permohonan)
    {   
        $this->request      = $request;

        $this->data         = (new DataFactory)->initData($this->request, $repository, $permohonan);

        $this->totalData    = $this->data->getTotalData();

        $this->totalKetData = method_exists($this->data, 'getTotalKetData') ? $this->data->getTotalKetData() : null;
    }

}
