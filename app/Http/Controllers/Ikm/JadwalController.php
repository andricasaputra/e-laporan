<?php

namespace App\Http\Controllers\Ikm;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ikm\Jadwal as Model;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingikm = Model::all();
        
        return view('intern.ikm.settingikm.index')
                ->withSettingikm($settingikm);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.settingikm.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'start_date' => 'required',
            'end_date' => 'required',
            'keterangan' => 'required|min:8'

        ]);

        $is_open = $this->IsOpen($request->start_date, $request->end_date);

        Model::create([

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_open' => $is_open,
            'keterangan' => $request->keterangan,

        ]);

        return redirect(route('intern.ikm.settingikm.index'))
                ->withSuccess('Data Berhasil Ditambah');
    }

    public function show(Request $request, Model $jadwal)
    {
        $cek = Model::whereId($jadwal->id)->first();
        
        if (Carbon::parse($cek->end_date) < Carbon::parse(date('Y-m-d')) && 
            $cek->is_open === null) {

            return redirect(route('intern.ikm.settingikm.index'))
                    ->withWarning('IKM ini sudah kadaluarsa');

        }

        $cek = Model::whereIsOpen(1)->get();

        if (count($cek) === 1 && $request->submit === 'Open') {

            return redirect(route('intern.ikm.settingikm.index'))
                    ->withWarning('Hanya diperbolehkan 1 survey IKM saja yang aktif');

        }

        if ($jadwal->is_open === '') {

            $request->is_open = NULL;

        }

        $jadwal->is_open = $request->is_open;

        $jadwal->save();

        return redirect(route('intern.ikm.settingikm.index'));
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $jadwal)
    {
        return view('intern.ikm.settingikm.edit')->withSettingikm($jadwal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Model $jadwal)
    {
        $request->validate([

            'start_date' => 'required',
            'end_date' => 'required'

        ]);

        $cek = Model::whereStartDate($request->start_date)
                    ->whereEndDate($request->end_date)
                    ->whereKeterangan($request->keterangan)
                    ->first();


        if (! is_null($cek)) {

            return redirect(route('intern.ikm.settingikm.index'))
                    ->withWarning('Data Jadwal IKM Tidak Boleh Ganda');

        }

       	$is_open = $this->IsOpen($request->start_date, $request->end_date);

        $jadwal->update([

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_open' => $is_open,
            'keterangan' => $request->keterangan,

        ]);

        return redirect(route('intern.ikm.settingikm.index'))
                ->withSuccess('Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $jadwal)
    {
        if ($jadwal->is_open === 1) {

            return redirect(route('intern.ikm.settingikm.index'))
                    ->withWarning('Tidak diperbolehkan menghapus survey yang sedang berlangsung');

        }

        if(count($jadwal->result) !== 0){

            return redirect(route('intern.ikm.settingikm.index'))
                    ->withWarning('IKM ini sudah terisi oleh beberapa responden dan tidak dapat dihapus');

        }

        $jadwal->delete();

        return redirect(route('intern.ikm.settingikm.index'))
                ->withSuccess('Data Berhasil Dihapus');
    }

    private function IsOpen($start_date, $end_date)
    {
    	$now          = now();

		$start_date   = Carbon::parse($start_date);

		$end_date     = Carbon::parse($end_date);

		return $now->between($start_date, $end_date) ? 1 : NULL;
    }
}
