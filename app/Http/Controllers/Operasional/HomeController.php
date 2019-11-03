<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Traits\Operasional\DataOperasionalKhTrait;
use App\Traits\Operasional\DataOperasionalKtTrait;
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
use App\Repositories\Operasional\DataOperasionalKhRepository as KhRepository;
use App\Repositories\Operasional\DataOperasionalKtRepository as KtRepository;

class HomeController extends Controller
{
    use DataOperasionalKhTrait, DataOperasionalKtTrait;

    /**
     * Untuk menyimpan instance dari object repository KH
     *
<<<<<<< HEAD
     * @var App\Repositories\Operasional\DataOperasionalKhRepository
=======
     * @var ObjectRepository
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    private $khRepository;

    /**
     * Untuk menyimpan instance dari object repository KT
     *
<<<<<<< HEAD
     * @var App\Repositories\Operasional\DataOperasionalKtRepository
=======
     * @var ObjectRepository
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @var int|null
=======
     * @var int / nullable
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    private $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
<<<<<<< HEAD
     * @var int|null
=======
     * @var int / nullable
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    private $wilker_id = null;

    /**
<<<<<<< HEAD
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route
=======
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route menjadi 1
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     *
     * @var array
     */
    public $routeParams;

    /**
     * Init repository and request for this class
     *
<<<<<<< HEAD
     * @param \Illuminate\Http\Request $request
=======
     * @param KhRepository $khRepository
     * @param KtRepository $ktRepository
     * @param Request $request
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
