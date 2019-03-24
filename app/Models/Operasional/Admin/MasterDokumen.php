<?php

namespace App\Models\Operasional\Admin;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class MasterDokumen extends Model
{
    //  Disable this trait if you're using shared hosting!
    use Cachable;
    
    protected $table 	= 'master_dokumen';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];

    /**
     * Untuk dokumen KT
     *
     * @param $query
     * @return void
     */
    public function scopeKtDokumen($query)
    {
        return $query->whereIn('karantina', ['kt', 'both'])->get();
    }

    /**
     * Untuk dokumen KH
     *
     * @param $query
     * @return void
     */
    public function scopeKhDokumen($query)
    {
        return $query->whereIn('karantina', ['kh', 'both'])->get();
    }

    /**
     * Untuk menjadikan dokumen uppercase
     *
     * @param string $value
     * @return string
     */
    public function getDokumenAttribute($value)
    {
    	return strtoupper($value);
    }

    /**
     * Untuk menjadikan deskripsi uppercase
     *
     * @param string $value
     * @return string
     */
    public function getDeskripsiAttribute($value)
    {
    	return strtoupper($value);
    }

    /**
     * Untuk mencari dokumen dan diubah tanpa tanda strip '-', ex : KT-12 -> KT12
     *
     * @param $query
     * @return array
     */
    public function scopeDokumenKtWithOutStripe($query)
    {
        $dok = $query->select('dokumen')->whereKarantina('kt')->get();
        
        return $dok->mapWithKeys(function($items){
            
            $dok = str_replace('-', '', $items->dokumen);
            $dok = str_replace(' ', '', $dok);
            
            return [$dok => $dok];
            
        });
    }

    /**
     * Untuk mencari dokumen dan diubah tanpa tanda strip '-', ex : KH-11 -> KH-14
     *
     * @param $query
     * @return array
     */
    public function scopeDokumenKhWithOutStripe($query)
    {
        $dok = $query->select('dokumen')->whereKarantina('kh')->get();
        
        return $dok->mapWithKeys(function($items){
            
            $dok = str_replace('-', '', $items->dokumen);
            $dok = str_replace(' ', '', $dok);
            
            return [$dok => $dok];
            
        });
    }
}
