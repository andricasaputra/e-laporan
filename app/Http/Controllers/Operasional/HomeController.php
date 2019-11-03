<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Operasional\DataOperasionalKhTrait;
use App\Traits\Operasional\DataOperasionalKtTrait;
use App\Repositories\Operasional\DataOperasionalKhRepository as KhRepository;
use App\Repositories\Operasional\DataOperasionalKtRepository as KtRepository;

class HomeController extends Controller
{
    use DataOperasionalKhTrait, DataOperasionalKtTrait;

    /**
     * Untuk menyimpan instance dari object repository KH
     *
     * @var App\Repositories\Operasional\DataOperasionalKhRepository
     */
    private $khRepository;

    /**
     * Untuk menyimpan instance dari object repository KT
     *
     * @var App\Repositories\Operasional\DataOperasionalKtRepository
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
     * @var int|null
     */
    private $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
     * @var int|null
     */
    private $wilker_id = null;

    /**
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route
     *
     * @var array
     */
    public $routeParams;

    /**
     * Init repository and request for this class
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->year         = $request->year ?? date('Y');

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;

        $this->routeParams  = [$this->year, $this->month, $this->wilker_id];

        $this->khRepository = new KhRepository($request);

        $this->ktRepository = new KtRepository($request);
    }

    /**
     * Untuk tampilan utama pada dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
    	return view('intern.operasional.home');
    }

    /**
     * API untuk menampilkan ringkasan data pada dashboard
     *
     * @return array
     */
    public function api()
    {
        return [

            'kh' => $this->sourceDashboardApiKh(),
            'kt' => $this->sourceDashboardApiKt()

        ];
    }

}
