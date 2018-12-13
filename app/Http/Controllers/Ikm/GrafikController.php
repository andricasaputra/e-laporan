<?php 

namespace App\Http\Controllers\Ikm;

use App\Repositories\Ikm\GrafikRepository;

class GrafikController
{
    /**
     * For keep repository instance on the bag
     *
     * @var App\Repositories\UserRepository
     */
    private $repository;
    private $id;

    /**
     * Set what repositories should use for this class
     *
     * @return App\Repositories Instance!
     */
    public function __construct(GrafikRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(int $id = null)
    {
    	$this->id = $id ?? $this->repository->default();

    	$keterangan = $this->repository->getKeterangan($this->id);
        
    	return view('intern.ikm.grafik.index')->with(compact('keterangan'));	           
    }

    /*create JSON chart data*/
    public function chartApi(int $id = null)
    {
    	$this->id = $id ?? $this->repository->default();

        return $this->repository->chartApi($this->id);
    }

}
