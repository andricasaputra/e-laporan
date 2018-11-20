<?php

namespace App\Http\Controllers\Ikm;

use Carbon;
use Illuminate\Http\Request;
use App\Models\Ikm\Jadwal as Model;
use App\Http\Controllers\Controller;

class Jadwal extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingikm = Model::all();
        return view('intern.ikm.settingikm.index')->with('settingikm', $settingikm);
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

            'start_date' => 'required|unique:ikm',
            'end_date' => 'required|unique:ikm',
            'keterangan' => 'required|min:8|unique:ikm'

        ]);

        $is_open = $this->IsOpen($request->start_date, $request->end_date);

        Model::create([

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_open' => $is_open,
            'keterangan' => $request->keterangan,

        ]);

        return redirect(route('intern.ikm.settingikm.index'))
        ->with('success', 'Data Berhasil Ditambah');
    }

    public function show(Request $request, int $id)
    {
        $cek = Model::where('id', $id)->first();

        if (strtotime($cek->end_date) < strtotime(date('Y-m-d'))) {
            return redirect(route('intern.ikm.settingikm.index'))
            ->with('warning', 'IKM ini sudah kadaluarsa');
        }

        $cek = Model::where('is_open', 1)->get();

        if (count($cek) === 1 && $request->submit === 'Open') {

            return redirect(route('intern.ikm.settingikm.index'))
            ->with('warning', 'Hanya diperbolehkan 1 survey IKM saja yang aktif');
        }

       $ikm = Model::find($id);

        if ($ikm->is_open === '') {

            $request->is_open = NULL;

        }

        $ikm->is_open = $request->is_open;

        $ikm->save();

        return redirect(route('intern.ikm.settingikm.index'));
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $settingikm = Model::find($id);

        return view('intern.ikm.settingikm.edit')->with('settingikm', $settingikm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([

            'start_date' => 'required',
            'end_date' => 'required'

        ]);

       	$is_open = $this->IsOpen($request->start_date, $request->end_date);

        Model::find($id)->update([

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_open' => $is_open,
            'keterangan' => $request->keterangan,

        ]);

        return redirect(route('intern.ikm.settingikm.index'))
        ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $jadwal = Model::find($id);

        if ($jadwal->is_open === 1) {
            return redirect(route('intern.ikm.settingikm.index'))
            ->with('warning', 'Tidak diperbolehkan menghapus survey yang sedang berlangsung');
        }

        if(count($jadwal->result) !== 0){
            return redirect(route('intern.ikm.settingikm.index'))
            ->with('warning', 'IKM ini sudah terisi oleh beberapa responden dan tidak dapat dihapus');
        }

        Model::destroy($id);

        return redirect(route('intern.ikm.settingikm.index'))
        ->with('success', 'Data Berhasil Dihapus');
    }

    private function IsOpen($start_date, $end_date)
    {
    	$now = Carbon::now();

		$start_date = Carbon::parse($start_date);

		$end_date = Carbon::parse($end_date);

		return $now->between($start_date, $end_date) ? 1 : NULL;
    }
}
