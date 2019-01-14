<?php

namespace App\Traits;

trait TableOperasionalProperty
{
	/**
     * Untuk Detail head table frekuensi KT
     *
     * @return array
     */
    protected function tableTitleKt() : array
    {
        return [
             'no',
             'bulan',
             'wilker',
             'no_permohonan',
             'no_aju',
             'tanggal_permohonan',
             'jenis_permohonan',
             'nama_pemohon',
             'nama_pengirim',
             'alamat_pengirim',
             'nama_penerima',
             'alamat_penerima',
             'jumlah_kemasan',
             'kota_asal',
             'asal',
             'kota_tujuan',
             'tujuan',
             'port_asal',
             'port_tujuan',
             'moda_alat_angkut_terakhir',
             'tipe_alat_angkut_terakhir',
             'nama_alat_angkut_terakhir',
             'status_internal',
             'lokasi_mp',
             'tempat_produksi',
             'nama_tempat_pelaksanaan',
             'peruntukan',
             'golongan',
             'kode_hs',
             'nama_komoditas',
             'nama_komoditas_en',
             'volume_netto',
             'sat_netto',
             'volume_bruto',
             'sat_bruto',
             'volume_lain',
             'sat_lain',
             'volumeP1',
             'nettoP1',
             'volumeP8',
             'nettoP8',
             'dok_pelepasan',
             'nomor_dok_pelepasan',
             'tanggal_pelepasan',
             'no_seri',
             'dokumen_pendukung',
             'kontainer',
             'biaya_perjalanan_dinas',
             'total_pnbp'
        ];
    }

    /**
     * Untuk Detail head table frekuensi KT
     * 
     * @return array
     */
    protected function tableTitleKh() : array
    {
        return [
            'no',
            'bulan',
            'wilker',
            'no_permohonan',
            'no_aju',
            'tanggal_permohonan',
            'jenis_permohonan',
            'nama_pemohon',
            'nama_pengirim',
            'alamat_pengirim',
            'nama_penerima',
            'alamat_penerima',
            'jumlah_kemasan',
            'kota_asal',
            'asal',
            'kota_tuju',
            'tujuan',
            'port_asal',
            'port_tuju',
            'moda_alat_angkut_terakhir',
            'tipe_alat_angkut_terakhir',
            'nama_alat_angkut_terakhir',
            'status_internal',
            'peruntukan',
            'jenis_mp',
            'kelas_mp',
            'kode_hs',
            'nama_mp',
            'nama_latin',
            'jumlah',
            'satuan',
            'jantan',
            'betina',
            'netto',
            'sat_netto',
            'bruto',
            'sat_bruto',
            'keterangan',
            'breed',
            'volumeP1',
            'nettoP1',
            'volumeP8',
            'nettoP8',
            'dok_pelepasan',
            'nomor_dok_pelepasan',
            'tanggal_pelepasan',
            'no_seri',
            'dokumen_pendukung',
            'kontainer',
            'biaya_perjalanan_dinas',
            'total_pnbp'
        ];
    }

    /**
     * Table head dari laporan operasional KT
     *
     * @return array
     */
    protected function tableHeaderLaporanOperasionalKt() : array
    {
        return [
             'No',
             'No Permohonan',
             'No Aju',
             'Tanggal Permohonan',
             'Jenis Permohonan',
             'Nama Pemohon',
             'Nama Pengirim',
             'Alamat Pengirim',
             'Nama Penerima',
             'Alamat Penerima',
             'Jumlah Kemasan',
             'Kota Asal',
             'Asal',
             'Kota Tujuan',
             'Tujuan',
             'Pelabuhan Asal',
             'Pelabuhan Tujuan',
             'Moda Alat Angkut Terakhir',
             'Tipe Alat Angkut Terakhir',
             'Nama Alat Angkut Terakhir',
             'Status Internal',
             'Lokasi Media Pembawa',
             'Tempat Produksi',
             'Nama Tempat Pelaksanaan',
             'Peruntukan',
             'Dokumen Pelepasan',
             'No Dokumen Pelepasan',
             'Tanggal Pelepasan',
             'Kode Komoditas',
             'Nama Komoditas',
             'Nama Ilmiah',
             'Volume Bersih',
             'Satuan Bersih',
             'Volume Kotor',
             'Satuan Kotor',
             'No Seri',
             'PNBP (Rp)'
            ];
    }

    /**
     * Table head dari laporan operasional KH
     *
     * @return array
     */
    protected function tableHeaderLaporanOperasionalKh() : array
    {
        return [
             'No',
             'No Permohonan',
             'No Aju',
             'Tanggal Permohonan',
             'Jenis Permohonan',
             'Nama Pemohon',
             'Nama Pengirim',
             'Alamat Pengirim',
             'Nama Penerima',
             'Alamat Penerima',
             'Jumlah Kemasan',
             'Kota Asal',
             'Asal',
             'Kota Tujuan',
             'Tujuan',
             'Pelabuhan Asal',
             'Pelabuhan Tujuan',
             'Moda Alat Angkut Terakhir',
             'Tipe Alat Angkut Terakhir',
             'Nama Alat Angkut Terakhir',
             'Status Internal',
             'Peruntukan',
             'Dokumen Pelepasan',
             'No Dokumen Pelepasan',
             'Tanggal Pelepasan',
             'Jenis Media Pembawa',
             'Kelas Media Pembawa',
             'Kode HS',
             'Nama Media Pembawa',
             'Nama Latin',
             'Jantan',
             'Betina',
             'Jumlah',
             'Satuan',
             'No Seri',
             'PNBP (Rp)'
            ];
    }
}