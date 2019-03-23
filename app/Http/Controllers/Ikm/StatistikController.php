<?php 

namespace App\Http\Controllers\Ikm;

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

    /**
     * For save StatistikComposer instance
     *
     * @var App\Http\View\Composers\Ikm\StatistikComposer
     */
    private $compose;
    
    /**
     * For keep repository instance on the bag
     *
     * @var App\Repositories\StatistikRepository
     */
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id = null)
    {
    	$this->id = $id ?? $this->repository->default();

        $this->compose->compose();

    	return view('intern.ikm.statistik.index');
    }

    /**
     * Display API
     *
     * @return \Illuminate\Http\Response
     */
    public function api(int $id = null)
    {
        $this->id = $id ?? $this->repository->default();

        return $this->repository->api($this->id);
    }

    /**
     * API source
     *
     * @return \Illuminate\Http\Response
     */
    public function apiSource()
    {
  		  return $this->repository->apiSource($this->id);
    }

    /**
     * Print Rekapitulasi Document
     *
     * @return PDF
     */
    public function cetakRekap(int $id)
    {
        $datas = $this->repository->cetakRekap($id);

        pdf()->pdf->setTitle('Rekapitulasi Survey Kepuasan Masyarakat');

        pdf()->writeHTML(view('intern.ikm.statistik.cetak', compact('datas')));

        return pdf()->output('Rekapitulasi Survey Kepuasan Masyarakat.pdf');
    }

}
