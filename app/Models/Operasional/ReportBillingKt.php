<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelReportBillingInterface;

class ReportBillingKt extends Model implements ModelReportBillingInterface
{
    use QueryScopeGlobalTrait;

    protected $table 	= 'report_billing_kt';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set parameter route
     * digunakan pada class UploadBillingController untuk set notifikasi property
     *
     * @var string
     */
    public $alias       = 'setor';

    /**
     * Untuk alias dari jenis permohonan
     * digunakan pada class UploadBillingController untuk set notifikasi property
     *
     * @var string
     */
    public $permohonan  = 'setor billing';

    /**
     * Untuk alias dari jenis karantina
     * digunakan pada class UploadBillingController untuk set notifikasi property
     *
     * @var string
     */
    public $karantina   = 'Karantina Tumbuhan';

    /**
     * Custom tanggal billing
     *
     * @return string
     */
    public function getBulanAttribute($value)
    {
        return \Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * Custom tanggal billing
     *
     * @return string
     */
 	public function getTglBillingAttribute($value)
    {
        return \Carbon::parse(str_replace("'", "", $value))->format('d-m-Y');
    }

    /**
     * Custom tanggal kwitansi
     *
     * @return string
     */
    public function getTglKwitansiAttribute($value)
    {
        return \Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
    }

    /**
     * Custom tanggal bayar/setor
     *
     * @return string
     */
    public function getTglBayarAttribute($value)
    {
        return \Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
    }

    /**
     * Custom kode billing
     *
     * @return string
     */
    public function getKodeBillingAttribute($value)
    {
        return str_replace("'", "", $value);
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
