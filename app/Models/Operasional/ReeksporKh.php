<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Operasional\ModelOperasionalInterface;

class ReeksporKh extends Model implements ModelOperasionalInterface
{
	use QueryScopeKhTrait;

    protected $table 	= 'reekspor_kh';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set parameter route
     * digunakan pada class UploadController untuk set notifikasi property
     *
     * @var string
     */
    public $alias       = 'reekspor';

    /**
     * Untuk alias dari jenis permohonan
     * digunakan pada class UploadController untuk set notifikasi property
     *
     * @var string
     */
    public $permohonan  = 'reekspor';

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

    /**
     * One to many relations
     *
     * @return void
     */
    public function wilker()
    {
        return $this->belongsTo(Wilker::class);
    }
}