<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;

class SerahTerimaKh extends Model implements ModelOperasionalInterface
{
	use QueryScopeKhTrait;

    protected $table 	= 'serah_terima_kh';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set parameter route
     * digunakan pada class UploadController untuk set notifikasi property
     *
     * @var string
     */
    public $alias       = 'serah_terima';

    /**
     * Untuk alias dari jenis permohonan
     * digunakan pada class UploadController untuk set notifikasi property
     *
     * @var string
     */
    public $permohonan  = 'serah terima';

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
        return bulan_tahun($value);
    }
}
