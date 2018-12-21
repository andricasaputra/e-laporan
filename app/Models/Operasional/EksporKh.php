<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;
use App\Http\Controllers\TanggalController as Tanggal;

class EksporKh extends Model implements ModelOperasionalInterface
{
    protected $table 	= 'ekspor_kh';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set parameter route
     * digunakan pada class UploadController untuk set notifikasi property
     *
     * @var string
     */
    public $alias       = 'ekspor';

    /**
     * Untuk alias dari jenis permohonan
     * digunakan pada class UploadController untuk set notifikasi property
     *
     * @var string
     */
    public $permohonan  = 'ekspor';

    /**
     * Untuk alias dari jenis karantina
     * digunakan pada class UploadController untuk set notifikasi property
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
        return Tanggal::bulanTahun($value);
    }

    /**
     * One to many relations
     *
     * @return void
     */
    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }

    /**
     * Untuk Menghitung Total Frekuensi Dari KT
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return int
     */
    public function scopeCountFrekuensi($query, $year, $month = null, $wilker_id = null)
    {
        $query->whereNotNull('nama_mp')->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->count();
    }

    /**
     * Untuk menghitung rekapitulasi kegiatan dan grouping
     * berdasarkan nama komoditas
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountRekapitulasi($query, $year, $month = null, $wilker_id = null)
    {
        $query->select('id', 'wilker_id', 'satuan', 'nama_mp')
              ->selectRaw(
                  'year(created_at) as year, 
                  month(bulan) as month, 
                  sum(jumlah) as volume, 
                  sum(total_pnbp) as pnbp,
                  count(satuan) as frekuensi'
                )
                ->whereNotNull('nama_mp')
                ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query->groupBy('nama_mp');
    }

    /**
     * Untuk menghitung total PNBP
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountTotalPnbp($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('sum(total_pnbp) as pnbp')  
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query;
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
    public function scopeCountPemakaianDokumen($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('dok_pelepasan as dokumen, count(dok_pelepasan) as total')
              ->whereNotNull('dok_pelepasan')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('dok_pelepasan');
    }

    /**
     * Untuk menghitung total frekuensi berdasarkan komoditas
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountFrekuensiKomoditi($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('year(bulan) as year, monthname(bulan) as bln, count(*) as data')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);

        return $query->groupBy('year', 'bln')->orderBy('bulan');
    }

    /**
     * Untuk menghitung top 5 frekuensi berdasarkan komoditas
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeTopFiveFrekuensiKomoditi($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('nama_mp as name, count(*) as data')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query->groupBy('nama_mp')->orderBy('data', 'desc')->limit(5);
    }
}
