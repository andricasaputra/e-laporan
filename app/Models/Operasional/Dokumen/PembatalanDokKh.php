<?php

namespace App\Models\Operasional\Dokumen;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;
use App\Models\Operasional\QueryScopeKhTrait;

class PembatalanDokKh extends Model implements ModelOperasionalInterface
{
	use QueryScopeKhTrait;

    protected $table 	= 'pembatalan_dok_kh';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set parameter route
     * digunakan pada class UploadPembatalanController untuk set notifikasi property
     *
     * @var string
     */
    public $alias       = 'pembatalan_dokumen';

    /**
     * Untuk alias dari jenis permohonan
     * digunakan pada class UploadPembatalanController untuk set notifikasi property
     *
     * @var string
     */
    public $permohonan  = 'pembatalan dokumen';

    /**
     * Untuk alias dari jenis karantina
     * digunakan pada class UploadPembatalanController untuk set notifikasi property
     *
     * @var string
     */
    public $karantina   = 'Karantina Hewan';

    /**
     * Custom nama bulan
     *
     * @return string
     */
 	public function getBulanAttribute($value)
    {
        return bulan_tahun($value);
    }

    /**
     * Untuk menghitung total pemakaian dokumen
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountPembatalanDokumen($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('dokumen, count(dokumen) as total')
              ->whereNotNull('dokumen')
              ->whereYear('bulan', $year);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('tanggal_batal', $month);

        })->when($wilker_id && $wilker_id != 'all', function ($query) use ($wilker_id) {

            return $query->whereWilkerId($wilker_id);

        });
                     
        return $query->groupBy('dokumen');
    }

    /**
     * Untuk memfilter pembatalan dokumen
     *
     * @param $query
     * @param array $params
     * @return collections
     */
    public function scopeGetPembatalan($query, array $params)
    {
        $query->whereYear('bulan', $params['year']);

        $query->when($params['month'] && $params['month'] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params['month']);

        })->when($params['wilkerId'] && $params['wilkerId'] != 'all', function ($query) use ($params) {

            return $query->whereWilkerId($params['wilkerId']);

        });

        return $query->get();
    }

    /**
     * Untuk mmenghitung jumlah pembatalan dokumen
     *
     * @param $query
     * @param array $params
     * @return collections
     */
    public function scopeGetJumlahKhDokumen($query, array $params)
    {
        $query->selectRaw('count(*) as total, dokumen, wilker_id, nomor_seri as no_seri')
              ->whereYear('bulan', $params['year']);

        $query->when($params['month'] && $params['month'] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params['month']);

        })->when($params['wilkerId'] && $params['wilkerId'] != 'all', function ($query) use ($params) {

            return $query->whereWilkerId($params['wilkerId']);

        });

        return $query->groupBy('dokumen', 'no_seri')->get();
    }
}
