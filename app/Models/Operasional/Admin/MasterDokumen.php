<?php

namespace App\Models\Operasional\Admin;

use Illuminate\Database\Eloquent\Model;

class MasterDokumen extends Model
{
    protected $table 	= 'master_dokumen';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];

    /**
     * Untuk dokumen KT
     *
     * @param self $query
     * @return void
     */
    public function scopeKtDokumen($query)
    {
        return $query->whereIn('karantina', ['kt', 'both'])->get();
    }

    /**
     * Untuk dokumen KH
     *
     * @param self $query
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
     * Untuk mengubah alias karantina, ex : kt -> Tumbuhan
     *
     * @param string $value
     * @return string
     */
    /*public function getKarantinaAttribute($value)
    {
    	switch ($value) {
    		case 'KT':
    		case 'Kt':
    		case 'kt':
    			$value = 'Tumbuhan';
    			break;
    		case 'KH':
    		case 'Kh':
    		case 'kh':
    			$value = 'Hewan';
    			break;
    		default:
    			$value = 'Hewan & Tumbuhan';
    			break;
    	}

    	return strtoupper($value);
    }*/

    /**
     * Untuk mencari dokumen dan diubah tanpa tanda strip '-', ex : KT-12 -> KT12
     *
     * @param self $query
     * @return array
     */
    public function scopeDokumenKtWithOutStripe($query)
    {
        $dok = $query->select('dokumen')->whereKarantina('kt')->get();
        
        return $dok->mapWithKeys(function($items){
            return [str_replace('-', '', $items->dokumen) => str_replace('-', '', $items->dokumen)];
        });
    }
}
