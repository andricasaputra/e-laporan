<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Ikm;

use Illuminate\View\View;
use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Responden;
use Illuminate\Support\Collection;

class Grafik extends Statistik
{
    public function index(int $id = null) : View
    {
    	if (!isset($id)) {

			$id = $this->getId();
		}

    	$ikm = Jadwal::select('id', 'keterangan')->get();
    	$ikm_ket = Jadwal::select('keterangan', 'start_date', 'end_date')->whereId($id)->first();
    	return view('intern.ikm.grafik.index')
    	->with(compact('ikm'))
    	->with('id', $id)
    	->with('ikm_ket', $ikm_ket);
    }

    /*create JSON chart data*/
    public function chartApi(int $id = null) : Collection
    {
    	if (!isset($id)) {

			$id = $this->getId();
		}

        $laki_laki  = Responden::select('jenis_kelamin')
                        ->where('ikm_id', $id)
                        ->where('jenis_kelamin', 1)
                        ->get()->count();
        $perempuan  = Responden::select('jenis_kelamin')
                        ->where('ikm_id', $id)
                        ->where('jenis_kelamin', 2)
                        ->get()->count();

        $datas      = Responden::where('ikm_id', $id)
                        ->with(['pendidikan', 'layanan', 'umur', 'pekerjaan'])->get();

        foreach ($datas as $value) {

            $umur[]         = $value->umur->umur;
            
            $pendidikan[]   = $value->pendidikan->pendidikan;

            $layanan[]      = $value->layanan->jenis_layanan;

            $pekerjaan[]    = $value->pekerjaan->pekerjaan;

        }

		$data = [
         'data'         => $this->apiSource($id),
         'jenis_kelamin'=> ['Laki_laki' => $laki_laki, 'Perempuan' => $perempuan],
         'pendidikan'   => array_count_values($pendidikan),
         'layanan'      => array_count_values($layanan),
         'umur'         => array_count_values($umur),
         'pekerjaan'    => array_count_values($pekerjaan),
        ];

        return collect($data);
    }
}
