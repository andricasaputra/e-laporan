<?php

namespace App\Models\Operasional\Dokumen;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Models\Operasional\QueryScopeKtTrait;
use App\Models\Operasional\Admin\MasterDokumen;
use App\Contracts\Operasional\ModelPembatalanInterface;

class PembatalanDokKt extends Model implements ModelPembatalanInterface
{
	use QueryScopeKtTrait;
	
    protected $table 	= 'pembatalan_dok_kt';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'no', 'created_at', 'updated_at'];
    protected $with     = ['wilker'];

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
    public $karantina   = 'Karantina Tumbuhan';

    /**
     * One to many relations with Wilker
     *
     * @return void
     */
    public function wilker()
    {
        return $this->belongsTo(Wilker::class);
    }

    /**
     * Untuk mencari nama dokumen yang sesuai dengan master dokumen
     *
     * @var string
     */
    public function getDokumenAttribute($value)
    {
        $value = str_replace(' ', '', $value);
        return MasterDokumen::dokumenKtWithOutStripe()[$value];
    }

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
        $query->whereNotNull('dokumen')->whereYear('bulan', $params['year']);

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
    public function scopeGetJumlahKtDokumen($query, array $params)
    {
        $query->selectRaw('count(*) as total, dokumen, wilker_id, nomor_seri as no_seri')
              ->whereNotNull('dokumen')
              ->whereYear('bulan', $params['year']);

        $query->when($params['month'] && $params['month'] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params['month']);

        })->when($params['wilkerId'] && $params['wilkerId'] != 'all', function ($query) use ($params) {

            return $query->whereWilkerId($params['wilkerId']);

        });

        return $query->groupBy('dokumen', 'no_seri')->get();
    }
}
