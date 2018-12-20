<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Operasional\DataOperasionalKhRepository as KhRepository;
use App\Repositories\Operasional\DataOperasionalKtRepository as KtRepository;

class HomeAdminController extends Controller
{
    use DataOperasionalKhTrait, DataOperasionalKtTrait;

    /**
     * Untuk menyimpan instance dari object repository KH
     *
     * @var ObjectRepository
     */
    private $khRepository;

    /**
     * Untuk menyimpan instance dari object repository KT
     *
     * @var ObjectRepository
     */
    private $ktRepository;

    /**
     * Untuk menyimpan parameter tahun dari url
     *
     * @var int
     */
    private $year;

    /**
     * Untuk menyimpan parameter bulan dari url
     *
     * @var int / nullable
     */
    private $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
     * @var int / nullable
     */
    private $wilker_id = null;

    /**
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route menjadi 1
     *
     * @var array
     */
    public $params;

    public function __construct(KhRepository $khRepository, KtRepository $ktRepository, Request $request)
    {
        $this->khRepository = $khRepository;

        $this->ktRepository = $ktRepository;

        $this->year         = $request->route()->parameter('year') ?? date('Y');

        $this->month        = $request->route()->parameter('month');

        $this->wilker_id    = $request->route()->parameter('wilker_id');

        $this->params       = [$this->year, $this->month, $this->wilker_id];

        $this->khRepository->setDateAndWilker($this->year, $this->month, $this->wilker_id);

        $this->ktRepository->setDateAndWilker($this->year, $this->month, $this->wilker_id);
    }

    public function show()
    {
    	return view('intern.operasional.home')
    	       ->with('dataKh', $this->statistikDataOperasionalKh())
               ->with('dataKt', $this->statistikDataOperasionalKt())
               ->with('wilkers', Wilker::all());
    }

    
}
