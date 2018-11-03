<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon;

use App\Models\Ikm\SettingIkm as Model;

class SettingIkm extends Controller
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
        ->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
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
