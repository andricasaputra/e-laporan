<?php

namespace App\Models\Operasional;

<<<<<<< HEAD
use Carbon\Carbon;
use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Operasional\ModelReportBillingInterface;
=======
use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelReportBillingInterface;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

class ReportBillingKh extends Model implements ModelReportBillingInterface
{
    use QueryScopeGlobalTrait;
    
    protected $table 	= 'report_billing_kh';
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
<<<<<<< HEAD
    public $permohonan  = 'billing';
=======
    public $permohonan  = 'setor billing';
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

    /**
     * Untuk alias dari jenis karantina
     * digunakan pada class UploadBillingController untuk set notifikasi property
     *
     * @var string
     */
    public $karantina   = 'Karantina Hewan';

    /**
     * Custom tanggal billing
     *
     * @return string
     */
    public function getBulanAttribute($value)
    {
<<<<<<< HEAD
        return Carbon::parse($value)->format('d-m-Y');
=======
        return \Carbon::parse($value)->format('d-m-Y');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

    /**
     * Custom tanggal billing
     *
     * @return string
     */
    public function getTglBillingAttribute($value)
    {
<<<<<<< HEAD
        return Carbon::parse(str_replace("'", "", $value))->format('d-m-Y');
=======
        return \Carbon::parse(str_replace("'", "", $value))->format('d-m-Y');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

    /**
     * Custom tanggal kwitansi
     *
     * @return string
     */
    public function getTglKwitansiAttribute($value)
    {
<<<<<<< HEAD
        return Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
=======
        return \Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

    /**
     * Custom tanggal bayar/setor
     *
     * @return string
     */
    public function getTglBayarAttribute($value)
    {
<<<<<<< HEAD
        return Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
=======
        return \Carbon::parse(str_replace("'", "", $value))->format('d-m-Y h:i:s');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
