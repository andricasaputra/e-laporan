<?php 

namespace App\Repositories\Ikm;

use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Responden;
use App\Contracts\RepositoryInterface;

class GrafikRepository extends StatistikRepository implements RepositoryInterface
{
    public $ikm;
    public $ikm_ket;
    public $id;

    public function getKeterangan($id)
    {
        $this->id       = $id;
        $this->ikm      = Jadwal::select('id', 'keterangan')->get();
        $this->ikm_ket  = Jadwal::select('keterangan', 'start_date', 'end_date')
                            ->whereId($id)
                            ->first();

        return $this;
    }

	public function chartApi($id)
    {
        $datas                  =   Responden::where('ikm_id', $id)->get();

        $data['data']           =   $this->apiSource($id);

        $data['jenis_kelamin']  =   [
                                        'Laki_laki' => $this->getJenisKelamin($id, 1), 
                                        'Perempuan' => $this->getJenisKelamin($id, 2)
                                    ];

        $data['umur']           =   $this->getUmur($datas);

        $data['pendidikan']     =   $this->getPendidikan($datas);

        $data['pekerjaan']      =   $this->getPekerjaan($datas);

        $data['layanan']        =   $this->getLayanan($datas);

        return collect($data);
    }

    public function getLayanan($datas)
    {
        return $datas->groupBy('layanan_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($layanan) use ($data){

                return [$layanan->layanan->jenis_layanan => $data->count()];

            })->all();
 
        })->all();
    }

    public function getUmur($datas)
    {
        return $datas->groupBy('umur_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($umur) use ($data){

                return [$umur->umur->umur => $data->count()];

            })->all();
 
        })->all();
    }

    public function getPendidikan($datas)
    {
        return $datas->groupBy('pendidikan_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($pendidikan) use ($data){

                return [$pendidikan->pendidikan->pendidikan => $data->count()];

            })->all();
 
        })->all();
    }

    public function getPekerjaan($datas)
    {
        return $datas->groupBy('pekerjaan_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($pekerjaan) use ($data){

                return [$pekerjaan->pekerjaan->pekerjaan => $data->count()];

            })->all();
 
        })->all();
    }

    private function getJenisKelamin(int $id, int $jenis_kelamin_id)
    {   
       return Responden::select('jenis_kelamin')
                ->where('ikm_id', $id)
                ->where('jenis_kelamin', $jenis_kelamin_id)
                ->get()
                ->count();     
    }
}