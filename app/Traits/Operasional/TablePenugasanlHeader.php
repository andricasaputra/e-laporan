<?php

namespace App\Traits\Operasional;

trait TablePenugasanlHeader
{
	/**
     * Untuk Detail head table frekuensi KT
     *
     * @return array
     */
    protected function tableTitlePenugasan() : array
    {
        return [
            'No',   
            'no_permohonan',
            'no_aju',
            'tanggal_permohonan',
            'jenis_permohonan',
            'nama_wilker',
            'nama_pengirim',
            'alamat_pengirim',
            'nama_penerima',
            'alamat_penerima',
            'nama_tercetak',
            'nama_latin_tercetak',
            'bentuk_tercetak',
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
            'dok_pelepasan',
            'nomor_dok_pelepasan',
            'tanggal_pelepasan',
            'no_surat_tugas',
            'tgl_surat_tugas',
            'deskripsi',
            'Petugas',
            'Dokumen_Pendukung',
            'Kontainer'

        ];
    }

    public function tableHeaderPenugasan() : array
    {
        return [
             "bulan",
             "no_permohonan",
             "no_aju",
             "tanggal_permohonan",
             "jenis_permohonan",
             "nama_wilker",
             "nama_pengirim",
             "alamat_pengirim",
             "nama_penerima",
             "alamat_penerima",
             "nama_tercetak",
             "nama_latin_tercetak",
             "bentuk_tercetak",
             "jumlah_kemasan",
             "kota_asal",
             "asal",
             "kota_tuju",
             "tujuan",
             "port_asal",
             "port_tuju",
             "moda_alat_angkut_terakhir",
             "tipe_alat_angkut_terakhir",
             "nama_alat_angkut_terakhir",
             "dok_pelepasan",
             "nomor_dok_pelepasan",
             "tanggal_pelepasan",
             "no_surat_tugas",
             "tgl_surat_tugas",
             "deskripsi",
             "petugas",
             "dokumen_pendukung",
             "kontainer",
             "created_at",
        ];
    }

}