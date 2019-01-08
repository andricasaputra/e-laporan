<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TanggalController as Tanggal;

class LogInfo extends Model
{
    protected $table 	= 'log_operasional';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];
    protected $with     = ['wilker'];

    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }

    public function getBulanAttribute($value)
    {
        if (strlen($value) > 4) return Tanggal::bulanTahun($value);

        return $value;
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
            case 'pembatalan_dok_kt':
                $type = 'Pembatalan Dokumen Karantina Tumbuhan';
                break;
            case 'pembatalan_dok_kh':
                $type = 'Pembatalan Dokumen Karantina Hewan';
                break;
            case 'reekspor_kh':
                $type = 'Re Ekspor Karantina Hewan';
                break;
            case 'reekspor_kt':
                $type = 'Re Ekspor Karantina Tumbuhan';
                break;
            case 'serah_terima_kh':
                $type = 'Serah Terima Karantina Hewan';
                break;
            case 'serah_terima_kt':
                $type = 'Serah Terima Karantina Tumbuhan';
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
        		$value = "(". \Carbon::parse($value)->format('d-m-Y') .")";
        		break;
        }

        return $value;
    }

    public function getCreatedAtAttribute($value)
    {
       return \Carbon::parse($value)->toDateTimeString();
    }

    public function scopeKarantinaTumbuhanType($query, $year, $month, $wilker, $type)
    {
        $query->whereYear('created_at', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker) and (int) $wilker !== 1) $query->whereWilkerId($wilker);  
             
        if (isset($type) and $type != 'all'){

            $query->where('type', $type);

        } else {

            $query->whereIn('type', 
                ['dokel_kt', 'domas_kt', 'ekspor_kt', 'impor_kt', 
                'serah_terima_kt', 'reekspor_kt', 'pembatalan_dok_kt']
            );

        }
                         
        return $query->latest();
    }

    public function scopeKarantinaHewanType($query, $year, $month, $wilker, $type)
    {
        $query->whereYear('created_at', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker) and (int) $wilker !== 1) $query->whereWilkerId($wilker);
                      
        if (isset($type) and $type != 'all'){

            $query->where('type', $type);

        } else {

            $query->whereIn('type', 
                ['dokel_kh', 'domas_kh', 'ekspor_kh', 'impor_kh', 
                'serah_terima_kh', 'reekspor_kh', 'pembatalan_dok_kh']
            );

        }
                         
        return $query->latest();
    }

}
