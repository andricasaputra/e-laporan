<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Operasional\ModelOperasionalInterface;

class EksporKh extends Model implements ModelOperasionalInterface
{
    use QueryScopeKhTrait;

    protected $table 	= 'ekspor_kh';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set argument route pada link notifikasi
     *
     * @var string
     */
    public $alias       = 'ekspor';

    /**
     * Untuk menyematkan identitas permohonan yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
     *
     * @var string
     */
    public $permohonan  = 'ekspor';

    /**
     * Untuk menyematkan identitas karantina yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
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
     * One to many relations with Wilker
     *
     * @return void
     */
    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }

}
