<?php

namespace App\Models\Operasional;

trait QueryScopeGlobalTrait
{
    /*
    |--------------------------------------------------------------------------
    | Info
    |--------------------------------------------------------------------------
    |
    | * Trait yang bersifat global, dan dapat dipakai pada ke dua buah trait yaitu
    |   QueryScopeKtTrait atau QueryScopeKhTrait
    |
    | * Digunakan untuk keperluan menampilkan data dari table views 
    |   untuk nama kolom yang sama saja
    |
    */

	/**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return void
     */
    public function scopeSortTableDetail($query, $year = null, $month = null, $wilker_id = null)
    {
        $year   = $year ?? date('Y');

        $query->whereYear('bulan', $year);

        if(isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if(isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);

        return $query;
    }

    /**
     * Untuk menghitung total pemakaian dokumen
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountPemakaianDokumen($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('dokumen, sum(total) as total')
              ->whereNotNull('dokumen')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('dokumen')->orderBy('total', 'desc');
    }

    /**
     * Untuk menghitung total PNBP
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountTotalPnbp($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('sum(pnbp) as pnbp')  
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);
                     
        return $query->first();
    }

    /**
     * Untuk mendapatkan nama sebenarnya dari singkatan permohonan
     *
     * @param $query
     * @param string $value
     * @return string
     */
    public function scopeGetPermohonanFullName($query, $value)
    {
        switch ($value) {
            case 'dokel':
                $type = 'Domestik Keluar';
                break;
            case 'domas':
                $type = 'Domestik Masuk';
                break;
            case 'ekspor':
                $type = 'Ekspor';
                break;
            case 'impor':
                $type = 'Impor';
                break;
            case 'pembatalan_dok':
                $type = 'Pembatalan Dokumen';
                break;
            case 'reekspor':
                $type = 'Re Ekspor';
                break;
            case 'serahterima':
                $type = 'Serah Terima';
                break;
            default:
                $type = 'Data Operasional Tidak Ditemukan';
                break;
        }

        return $type;
    }
    
}