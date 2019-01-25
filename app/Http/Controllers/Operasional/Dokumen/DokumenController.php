<?php

namespace App\Http\Controllers\Operasional\Dokumen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Operasional\Dokumen\StokAwalDokumen;
use App\Repositories\Operasional\DokumenRepository as Repository;

class DokumenController extends Controller
{
	/**
     * Menyimpan data tahun
     *
     * @var string|int
     */
	protected $year;

	/**
     * Menyimpan data bulan
     *
     * @var string|int
     */
	protected $month;

	/**
     * Menyimpan data wilkerId
     *
     * @var string|int
     */
	protected $wilkerId;

	/**
     * menyimpan instance dari repository yang dipakai
     *
     * @var App\Repositories\Operasional\DokumenRepository
     */
	protected $repository;

	/**
     * Set properties untuk class ini
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
	public function __construct(Request $request)
	{
		$this->year 		= $request->year ?? date('Y');
		$this->month 		= $request->month;
		$this->wilkerId 	= $request->wilkerId;
		$this->repository 	= new Repository($this->year, $this->month, $this->wilkerId);
	}

    /**
     * Display a listing of the resource KT.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexKt()
    {
        return view('intern.operasional.kt.dokumen.menu')
        		->withDatas($this->datasKt());
    }	

    /**
     * Display a listing of the resource KH.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexKh()
    {
        return view('intern.operasional.kh.dokumen.menu')
        		->withDatas($this->datasKh());
    }		

    /**
     * menyimpan instance dari repository yang dipakai
     *
     * @return App\Repositories\Operasional\DokumenRepository
     */
    public function getRepository()
    {
    	return $this->repository;
    }

    /**
     * Source data yang akan dikirim ke dokumen view KT 
     *
     * @return array
     */
    public function datasKt()
    {
    	return $this->repository->dokumenKtDataSource();
    }

    /**
     * Source data yang akan dikirim ke dokumen view KH 
     *
     * @return array
     */
    public function datasKh()
    {
    	return $this->repository->dokumenKhDataSource();
    }

    public function dataDokumenKt()
    {
    	return view('intern.operasional.kt.dokumen.data')
    			->withDatas($this->datasKt());
    }

    public function dataDokumenKh()
    {
    	return view('intern.operasional.kh.dokumen.data')
    			->withDatas($this->datasKh());
    }

}
