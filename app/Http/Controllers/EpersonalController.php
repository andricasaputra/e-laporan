<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EpersonalRepository;

class EpersonalController extends Controller
{
    protected $repository;

    public function __construct(Request $request)
    {
        $this->repository = new EpersonalRepository($request);
    }

    public function index()
    {
        return view('intern.epersonal.index')
             ->withDatas($this->repository->getRouteParams());
    }

    public function getSkp()
    {
       return $this->repository->initialize()->getSkp()->store();
    }

    public function tableApi($year = null, $month = null)
    {
        return $this->repository->tableData($year, $month);
    }

}
