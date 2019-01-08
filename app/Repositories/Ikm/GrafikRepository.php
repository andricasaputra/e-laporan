<?php 

namespace App\Repositories\Ikm;

use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Responden;
use App\Contracts\RepositoryInterface;

class GrafikRepository extends StatistikRepository implements RepositoryInterface
{
    /**
     * Untuk menyimpan semua data IKM yang dipilih sesuai periode
     * Default IKM Yang aktif
     *
     * @var Collectios
     */
    public $ikm;

    /**
     * Untuk menyimpan data keterangan IKM 
     *
     * @var Collectios
     */
    public $ikm_ket;

    /**
     * Untuk menyimpan id IKM yang dipilih
     *
     * @var int
     */
    public $id;

    /**
     * Untuk set keterangan E - IKM yang sedang aktif 
     * pada tampilan charts 
     *
     * @param int $id
     * @return void 
     */
    public function getKeterangan($id)
    {
        $this->id       = $id;
        $this->ikm      = Jadwal::select('id', 'keterangan')->get();
        $this->ikm_ket  = Jadwal::select('keterangan', 'start_date', 'end_date')
                            ->whereId($id)
                            ->first();

        return $this;
    }

    /**
     * Untuk API charts Utama, Kumpulan dari beberapa method
     *
     * @param int $id
     * @return array | collections 
     */
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

    /**
     * Untuk set data layanan E -IKM
     *
     * @param array | collections $datas
     * @return array 
     */
    public function getLayanan($datas)
    {
        return $datas->groupBy('layanan_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($layanan) use ($data){

                return [$layanan->layanan->jenis_layanan => $data->count()];

            })->all();
 
        })->all();
    }

    /**
     * Untuk set data umur responden E -IKM
     *
     * @param array | collections $datas
     * @return array 
     */
    public function getUmur($datas)
    {
        return $datas->groupBy('umur_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($umur) use ($data){

                return [$umur->umur->umur => $data->count()];

            })->all();
 
        })->all();
    }

    /**
     * Untuk set data pendidikan responden E -IKM
     *
     * @param array | collections $datas
     * @return array 
     */
    public function getPendidikan($datas)
    {
        return $datas->groupBy('pendidikan_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($pendidikan) use ($data){

                return [$pendidikan->pendidikan->pendidikan => $data->count()];

            })->all();
 
        })->all();
    }

    /**
     * Untuk set data pekerjaan responden E -IKM
     *
     * @param array | collections $datas
     * @return array 
     */
    public function getPekerjaan($datas)
    {
        return $datas->groupBy('pekerjaan_id')->mapWithKeys(function($data){

            return $data->mapWithKeys(function($pekerjaan) use ($data){

                return [$pekerjaan->pekerjaan->pekerjaan => $data->count()];

            })->all();
 
        })->all();
    }

    /**
     * Untuk menghitung data sesuai jenis kelamin responden E -IKM
     *
     * @param int $id
     * @param int $jenis_kelamin_id
     * @return int 
     */
    private function getJenisKelamin(int $id, int $jenis_kelamin_id)
    {   
       return Responden::select('jenis_kelamin')
                ->where('ikm_id', $id)
                ->where('jenis_kelamin', $jenis_kelamin_id)
                ->get()
                ->count();     
    }
}