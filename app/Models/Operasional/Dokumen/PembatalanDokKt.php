<?php

namespace App\Models\Operasional\Dokumen;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;
use App\Models\Operasional\QueryScopeKtTrait;
use App\Models\Operasional\Admin\MasterDokumen;

class PembatalanDokKt extends Model implements ModelOperasionalInterface
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
              ->where('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('tanggal_batal', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('dokumen')->orderBy('total', 'desc');
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
    public function scopeGetJumlahKtDokumen($query, array $params)
    {
        $query->selectRaw('count(*) as total, dokumen, wilker_id, nomor_seri as no_seri')
              ->whereYear('bulan', $params['year']);

        $query->when($params['month'] && $params['month'] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params['month']);

        })->when($params['wilkerId'] && $params['wilkerId'] != 'all', function ($query) use ($params) {

            return $query->whereWilkerId($params['wilkerId']);

        });

        return $query->groupBy('dokumen', 'wilker_id')->get();
    }
}
