<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TanggalController as Tanggal;

class Jadwal extends Model
{
	protected $table ='ikm';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['id','start_date', 'end_date', 'is_open', 'created_at', 'updated_at'];

    // public function getStartDateAttribute($value)
    // {
    //     return Tanggal::tanggalIndo($value);
    // }

    // public function getEndDateAttribute($value)
    // {
    //     return Tanggal::tanggalIndo($value);
    // }

    public function result()
    {
        return $this->hasMany(Result::class, 'ikm_id');
    }
}
