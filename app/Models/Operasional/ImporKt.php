<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;
use App\Http\Controllers\TanggalController as Tanggal;

class ImporKt extends Model implements ModelOperasionalInterface
{
    protected $table 	= 'impor_kt'; 
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];
    public $alias       = 'impor';
    public $permohonan  = 'impor';
    public $karantina   = 'Karantina Tumbuhan';

    public function getBulanAttribute($value)
    {
        return Tanggal::bulanTahun($value);
    }

    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }

    public function scopeCountFrekuensi($query, $year, $month = null, $wilker_id = null)
    {
        $query->where('nomor_dok_pelepasan','!=', NULL)
                     ->whereYear('bulan', $year);

        if (isset($month)) $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->count();
    }

    public function scopeCountRekapitulasi($query, $year, $month = null, $wilker_id = null)
    {
        $query->select('id', 'wilker_id', 'sat_netto', 'nama_komoditas')
              ->selectRaw(
                  'year(created_at) as year, 
                  month(bulan) as month, 
                  sum(volume_netto) as volume, 
                  sum(total_pnbp) as pnbp,
                  count(volume_netto) as frekuensi'
                )
              ->where('nomor_dok_pelepasan','!=', NULL)
              ->whereYear('bulan', $year);

        if (isset($month)) $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query->groupBy('nama_komoditas');
    }

    public function scopeCountTotalPnbp($query, $year, $month = null)
    {
        $query->selectRaw('sum(total_pnbp) as pnbp')->whereYear('bulan', $year);

        if (isset($month)) $query->whereMonth('bulan', $month);
                     
        return $query;
    }

    public function scopeCountPemakaianDokumen($query, $year, $month = null)
    {
        $query->selectRaw('dok_pelepasan as dokumen, count(dok_pelepasan) as total')
              ->whereNotNull('dok_pelepasan')
              ->whereYear('bulan', $year);

        if (isset($month)) $query->whereMonth('bulan', $month);
                     
        return $query->groupBy('dok_pelepasan');
    }

}
