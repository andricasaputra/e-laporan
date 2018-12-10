<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TanggalController as Tanggal;

class LogInfo extends Model
{
    protected $table 	= 'log_operasional';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];

    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }

    public function getBulanAttribute($value)
    {
        return Tanggal::bulanTahun($value);
    }

    public function getTypeAttribute($value)
    {
        switch ($value) {
        	case 'dokel_kt':
        		$type = 'Domestik Keluar Karantina Tumbuhan';
        		break;
        	case 'domas_kt':
        		$type = 'Domestik Masuk Karantina Tumbuhan';
        		break;
        	case 'ekspor_kt':
        		$type = 'Ekspor Karantina Tumbuhan';
        		break;
        	case 'impor_kt':
        		$type = 'Impor Karantina Tumbuhan';
        		break;
        	case 'dokel_kh':
        		$type = 'Domestik Keluar Karantina Hewan';
        		break;
        	case 'domas_kh':
        		$type = 'Domestik Masuk Karantina Hewan';
        		break;
        	case 'ekspor_kh':
        		$type = 'Ekspor Karantina Hewan';
        		break;
        	case 'impor_kh':
        		$type = 'Impor Karantina Hewan';
        		break;
        	default:
        		$type = 'Data Operasional Tidak Ditemukan';
        		break;
        	
        }

        return $type;
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
        	case 1:
        		$value = "Laporan Berhasil Ditarik Kembali";
        		break;
        	
        	default:
        		$value = "Laporan Berhasil Diupload";
        		break;
        }

        return $value;
    }

    public function getRolledbackAtAttribute($value)
    {
        switch ($value) {
        	case NULL:
        		$value = "";
        		break;
        	
        	default:
        		$value = $value;
        		break;
        }

        return $value;
    }

}
