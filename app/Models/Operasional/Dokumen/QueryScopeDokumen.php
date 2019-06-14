<?php

namespace App\Models\Operasional\Dokumen;

use App\Models\User;
use App\Models\Wilker;
use App\Models\Operasional\Admin\MasterDokumen;

trait QueryScopeDokumen
{
    /**
     * One To Many Inverse by Wilker 
     *
     * @return void
     */
    public function wilker()
    {
        return $this->belongsTo(Wilker::class);
    }

    /**
     * One To Many Inverse by User 
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One To Many Inverse by Dokumen 
     *
     * @return void
     */
    public function dokumen()
    {
        return $this->belongsTo(MasterDokumen::class, 'dokumen_id', 'id');
    }

    /**
     * Untuk set tipe dokumen KT
     *
     * @param $query
     * @return Illuminate\Support\Collections
     */
    public function scopeKtDokumen($query)
    {
        return $query->with(['dokumen' => function($query){

            $query->whereIn('karantina', ['kt', 'both']);

        }]);
    }

    /**
     * Untuk set tipe dokumen KH
     *
     * @param $query
     * @return Illuminate\Support\Collections
     */
    public function scopeKhDokumen($query)
    {
        return $query->with(['dokumen' => function($query){

           $query->whereIn('karantina', ['kh', 'both']);
            
        }]);
    }

    /**
     * Untuk mmenghitung jumlah persediaan/penerimaan dokumen KT
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collections
     */
    public function scopeGetJumlahKtDokumen($query, array $arguments)
    {
        $query->selectRaw('sum(jumlah) as total, dokumen_id, wilker_id, no_seri')
              ->ktDokumen()
              ->whereYear('created_at', $arguments['year']);

        $query->when($arguments['month'] && $arguments['month'] != 'all', function ($query) use ($arguments) {

            return $query->whereMonth('created_at', $arguments['month']);

        })->when($arguments['wilkerId'] && $arguments['wilkerId'] != 'all', function ($query) use ($arguments) {

            return $query->whereWilkerId($arguments['wilkerId']);

        });

        return $query->whereIn('dokumen_id', $this->setDokumenKt())
                     ->groupBy('dokumen_id', 'wilker_id', 'no_seri')
                     ->get();
    }

    /**
     * Untuk mmenghitung jumlah persediaan/penerimaan dokumen KH
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collections
     */
    public function scopeGetJumlahKhDokumen($query, array $arguments)
    {
        $query->selectRaw('sum(jumlah) as total, dokumen_id, wilker_id, no_seri')
              ->khDokumen()
              ->whereYear('created_at', $arguments['year']);

        $query->when($arguments['month'] && $arguments['month'] != 'all', function ($query) use ($arguments) {

            return $query->whereMonth('created_at', $arguments['month']);

        })->when($arguments['wilkerId'] && $arguments['wilkerId'] != 'all', function ($query) use ($arguments) {

            return $query->whereWilkerId($arguments['wilkerId']);

        });

        return $query->whereIn('dokumen_id', $this->setDokumenKh())
                     ->groupBy('dokumen_id', 'wilker_id', 'no_seri')
                     ->get();
    }

    /**
     * Untuk mendapatkan pembatalan dokumen berdasarkan nama dokumen KT
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collections
     */
    public function scopeGetByNamaDokumenKt($query, array $arguments)
    {
        $query->ktDokumen()->whereYear('created_at', $arguments['year']);

        $query->when($arguments['month'] && $arguments['month'] != 'all', function ($query) use ($arguments) {

            return $query->whereMonth('created_at', $arguments['month']);

        })->when($arguments['wilkerId'] && $arguments['wilkerId'] != 'all', function ($query) use ($arguments) {

            return $query->whereWilkerId($arguments['wilkerId']);

        });

        return $query->whereIn('dokumen_id', $this->setDokumenKt())->get();
    }

    /**
     * Untuk mendapatkan pembatalan dokumen berdasarkan nama dokumen KT
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collections
     */
    public function scopeGetByNamaDokumenKh($query, array $arguments)
    {
        $query->khDokumen()->whereYear('created_at', $arguments['year']);

        $query->when($arguments['month'] && $arguments['month'] != 'all', function ($query) use ($arguments) {

            return $query->whereMonth('created_at', $arguments['month']);

        })->when($arguments['wilkerId'] && $arguments['wilkerId'] != 'all', function ($query) use ($arguments) {

            return $query->whereWilkerId($arguments['wilkerId']);

        });

        return $query->whereIn('dokumen_id', $this->setDokumenKh())->get();
    }

    /**
     * Ambil id dari dokumen untuk karantina hewan
     *
     * @return array|null
     */
    private function setDokumenKh() : ?array
    {
        return MasterDokumen::khDokumen()
                ->pluck('id')->unique()->all();
    }

    /**
     * Ambil id dari dokumen untuk karantina tumbuhan
     *
     * @return array|null
     */
    private function setDokumenKt() : ?array
    {
        return MasterDokumen::ktDokumen()
                ->pluck('id')->unique()->all();
    }
}

