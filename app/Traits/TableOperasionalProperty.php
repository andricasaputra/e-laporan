<?php

namespace App\Traits;

trait TableOperasionalProperty
{
	/**
     *Digunakan mencetak semua table kt head pada masing2 class turunan
     *dan kemuadian masing2 child class mengoper ke view yang diperlukan 
     *
     * @return array
     */
    protected function tableTitleKt() : array
    {
        return array(
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
        );
    }

    /**
     *Digunakan mencetak semua table kh head pada masing2 class turunan
     *dan kemuadian masing2 child class mengoper ke view yang diperlukan
     * 
     * @return array
     */
    protected function tableTitleKh() : array
    {
        return array(
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
        );
    }
}