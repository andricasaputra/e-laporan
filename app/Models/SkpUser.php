<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpUser extends Model
{
    use HasFactory;

    protected $table = 'skp_user';
    protected $guarded = ['id'];
    protected $appends = ['bk'];

    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class, 'user_id', 'user_id');
    }

    /**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param array $arguments
     * @return void
     */
    public function scopeSortTableDetail($query, array $arguments)
    {
        $query->whereYear('tanggal', $arguments[0] ?? date('Y'));

        $query->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

          return $query->whereMonth('tanggal', $arguments[1]);

        });

        return $query;
    }

    public function getBkAttribute()
    {
        try {

            $ex = explode("-", $this->attributes['butir_kegiatan']);

            $bk = trim($ex[1]);

            $bkModel = app()->make('BK');

            $bkUtama = (new $bkModel)->getAllBk($bk);

            if($bkUtama == '' || is_null($bkUtama) || empty($bkUtama)){

                $bk = trim($ex[1]);

                $ex = explode(":", $bk);

                 return (new $bkModel)->getAllBkPenunjang($ex[1]);
            }

            return $bkUtama;
            
        } catch (\Exception $e) {

            return;
            
        }
    }

}
