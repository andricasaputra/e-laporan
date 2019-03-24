<?php

namespace App\Models\Operasional;

use Carbon\Carbon;
use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Operasional\ModelReportBillingInterface;

class ReportBillingKt extends Model implements ModelReportBillingInterface
{
    use QueryScopeGlobalTrait;

    protected $table 	= 'report_billing_kt';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];

    /**
     * Untuk alias dari jenis permohonan untuk set argument route pada link notifikasi
     *
     * @var string
     */
    public $alias       = 'setor';

    /**
     * Untuk menyematkan identitas permohonan yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
     *
     * @var string
     */
    public $permohonan  = 'billing';

    /**
     * Untuk menyematkan identitas karantina yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
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
        return Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * Custom tanggal billing
     *
     * @return string
     */
 	public function getTglBillingAttribute($value)
    {
        return Carbon::parse(str_replace("'", "", $value))->format('d-m-Y');
    }

    /**
     * Custom tanggal kwitansi
     *
     * @return string
     */
    public function getTglKwitansiAttribute($value)
    {
        return Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
    }

    /**
     * Custom tanggal bayar/setor
     *
     * @return string
     */
    public function getTglBayarAttribute($value)
    {
        return Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
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
