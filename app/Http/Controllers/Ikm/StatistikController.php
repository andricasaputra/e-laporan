<?php 

namespace App\Http\Controllers\Ikm;

use PDF;
use App\Http\Controllers\Controller;
use App\Http\View\Composers\Ikm\StatistikComposer;
use App\Repositories\Ikm\StatistikRepository as Statistiks;

class StatistikController extends Controller
{
    /**
     * For keep repository instance on the bag
     *
     * @var App\Repositories\StatistikRepository
     */
    public $id;
    private $compose;
    private $repository;

    /**
     * Set what repositories should use for this class
     *
     * @return Object Instance!
     */
    public function __construct(Statistiks $repository)
    {
        $this->repository   = $repository;

        $this->compose      = StatistikComposer::construct($this);
    }

    public function index(int $id = null)
    {
    	$this->id = $id ?? $this->repository->default();

        $this->compose->compose();

    	return view('intern.ikm.statistik.index');
    }

    public function api(int $id = null)
    {
        $this->id = $id ?? $this->repository->default();

        return $this->repository->api($this->id);
    }

    public function apiSource()
    {
  		return $this->repository->apiSource($this->id);
    }

    public function cetakRekap(int $id)
    {
        $datas = $this->repository->cetakRekap($id);

        $pdf = PDF::loadView('intern.ikm.statistik.cetak', compact('datas'));

        return $pdf->stream('ikm.pdf');
    }

}
