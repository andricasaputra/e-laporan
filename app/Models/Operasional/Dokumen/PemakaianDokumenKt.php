<?php

namespace App\Models\Operasional\Dokumen;

use Illuminate\Database\Eloquent\Model;
use App\Models\Operasional\QueryScopeKtTrait;

class PemakaianDokumenKt extends Model
{
    use QueryScopeKtTrait, QueryScopeDokumen;

	protected $table = 'v_pemakaian_dokumen_kt'; 

    /**
     * Untuk menghitung total pemakaian dokumen
     *
     * @param $query
     * @param array $params
     * @return collections
     */
	public function scopeGetJumlahKtDokumen($query, array $params)
    {
        $query->selectRaw('sum(jumlah) as total, dokumen, wilker_id, no_seri')
              ->with('wilker')->whereYear('bulan', $params['year']);

        $query->when($params['month'] && $params['month'] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params['month']);

        })->when($params['wilkerId'] && $params['wilkerId'] != 'all', function ($query) use ($params) {

            return $query->whereWilkerId($params['wilkerId']);

        });

        return $query->groupBy('dokumen', 'wilker_id', 'no_seri')->get();
    }
}
