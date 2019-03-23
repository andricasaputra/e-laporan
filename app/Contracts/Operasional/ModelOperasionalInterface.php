<?php

namespace App\Contracts\Operasional;

interface ModelOperasionalInterface
{
	/**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param array $params
     * @return void
     */
    public function scopeSortTableDetail($query, array $params);

    /**
     * Untuk Menghitung Total Frekuensi Dari KH/KT Berdasarkan permohonan
     * Kita ambil data bukan dari tabel view melainkan dari tabel utama
     *
     * @param $query
     * @param array $params
     * @return int
     */
    public function scopeCountFrekuensiByPermohonan($query, array $params);

    /**
     * Untuk menghitung total frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param array $params
     * @return Illuminate\Support\Collection
     */
    public function scopeCountFrekuensiByKomoditi($query, array $params);

    /**
     * Untuk menghitung total pemakaian dokumen dalam satu tahun
     *
     * @param $query
     * @param array $params
     * @return Illuminate\Support\Collection
     */
    public function scopeCountPemakaianDokumen($query, array $params);
}