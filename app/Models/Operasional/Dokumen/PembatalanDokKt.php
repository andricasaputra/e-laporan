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
     * Untuk alias dari jenis permohonan untuk set argument route pada link notifikasi
     *
     * @var string
     */
    public $alias       = 'pembatalan_dokumen';

    /**
     * Untuk menyematkan identitas permohonan yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
     *
     * @var string
     */
    public $permohonan  = 'pembatalan dokumen';

    /**
     * Untuk menyematkan identitas karantina yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
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
     * @return string
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
     * Untuk mmenghitung jumlah pembatalan dokumen
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collections
     */
    public function scopeGetJumlahPembatalanKtDokumen($query, array $arguments)
    {
        $query->selectRaw('count(*) as total, dokumen')
              ->whereNotNull('dokumen')
              ->whereYear('bulan', $arguments['year']);

        $query->when($arguments['month'] && $arguments['month'] != 'all', function ($query) use ($arguments) {

            return $query->whereMonth('bulan', $arguments['month']);

        })->when($arguments['wilkerId'] && $arguments['wilkerId'] != 'all', function ($query) use ($arguments) {

            return $query->whereWilkerId($arguments['wilkerId']);

        });

        return $query->groupBy('dokumen')->get();
    }

    /**
     * Untuk mmenghitung jumlah pembatalan dokumen
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collections
     */
    public function scopeGetJumlahPembatalanPerWilkerKtDokumen($query, array $arguments)
    {
        $query->selectRaw('count(*) as total, dokumen, wilker_id, nomor_seri as no_seri')
              ->whereNotNull('dokumen')
              ->whereYear('bulan', $arguments['year']);

        $query->when($arguments['month'] && $arguments['month'] != 'all', function ($query) use ($arguments) {

            return $query->whereMonth('bulan', $arguments['month']);

        })->when($arguments['wilkerId'] && $arguments['wilkerId'] != 'all', function ($query) use ($arguments) {

            return $query->whereWilkerId($arguments['wilkerId']);

        });

        return $query->groupBy('dokumen', 'no_seri', 'wilker_id')->get();
    }
}
