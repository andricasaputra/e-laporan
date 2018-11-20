<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Ikm;

use App\Models\Ikm\Jadwal;

class Grafik extends Statistik
{
    public function index(int $id = null)
    {
    	if (!isset($id)) {

			$id = $this->getId();
		}

    	$ikm = Jadwal::select('id', 'keterangan')->get();
    	$ikm_ket = Jadwal::select('keterangan')->whereId($id)->first();
    	return view('intern.ikm.grafik.index')
    	->with(compact('ikm'))
    	->with('id', $id)
    	->with('ikm_ket', $ikm_ket);
    }

    /*create JSON chart data*/
    public function chartApi(int $id = null)
    {
    	if (!isset($id)) {

			$id = $this->getId();
		}

		$data = $this->apiSource($id);

        return collect($data);
    }
}
