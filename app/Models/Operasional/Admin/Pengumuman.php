<?php

namespace App\Models\Operasional\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table 	= 'pengumuman';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];
    protected $with 	= ['user'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    /**
     * Untuk menjabarkan dari show attribute
     *
     * @param Illuminate\Support\Collection $value
     * @return string
     */
    public function getShowAttribute($value)
    {
    	switch ($value) {
    		case 1:
    		case '1':
    			$value = 'Sedang ditampilkan';
    			break;
    		
    		default:
    			$value = 'Tidak ditampilkan';
    			break;
    	}

    	return $value;
    }

    /**
     * Untuk mengambil data yang sedang aktif
     *
     * @param $value
     * @return Illuminate\Support\Collection
     */
    public function scopeActive($query)
    {
    	return $query->whereShow(1)->latest()->paginate();
    }
}
