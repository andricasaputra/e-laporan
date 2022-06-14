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
        $skp = $this->repository->tableData($year, $month);

        return datatables($skp)
            ->addIndexColumn() 
            ->editColumn('bulan', function($data){
                return month_to_bulan($data->bulan) . ' ' . $data->tahun;
            })
            ->removeColumn('user_id')
            ->make(true);
    }

}
