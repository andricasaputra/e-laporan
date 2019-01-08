<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;
use App\Http\Controllers\TanggalController as Tanggal;

class PembatalanDokKt extends Model implements ModelOperasionalInterface
{
	use QueryScopeKtTrait;
	
    protected $table 	= 'pembatalan_dok_kt';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];

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
     * Custom nama bulan
     *
     * @return string
     */
 	public function getBulanAttribute($value)
    {
        return Tanggal::bulanTahun($value);
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
}
