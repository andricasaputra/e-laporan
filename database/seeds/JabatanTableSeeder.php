<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jabatan')->insert([
            
            [
            	'jabatan' => 'Kepala UPT',
            	'klasifikasi' => 'nonjf'
            ],
            [
            	'jabatan' => 'Kepala Urusan Tata Usaha',
            	'klasifikasi' => 'nonjf'
            ],
            [
            	'jabatan' => 'Kepala Subseksi Pelayanan & Operasional',
            	'klasifikasi' => 'nonjf'
            ],
            [
            	'jabatan' => 'Bendahara Pengeluaran',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Bendahara Penerimaan',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Penyusun Rencana Kegiatan dan Anggaran',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Penyusun Laporan',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pengadministrasi dan Penyaji Data',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Petugas SAK',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Petugas SIMAK BMN',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Penata Usaha BMN',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Verifikator Keuangan Penguji SPM',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Verifikator Keuangan',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pembuat Dafar Gaji',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pengadministrasi Keuangan',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pengelola Data PNBP',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pengadministrasi Kepegawaian',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pengadministrasi Umum',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Pengelola Laboratorium',
            	'klasifikasi' => 'administrasi'
            ],
            [
            	'jabatan' => 'Paramedik Veteriner Pemula',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Paramedik Veteriner Pelaksana',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Paramedik Veteriner Mahir',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Paramedik Veteriner Penyelia',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Medik Veteriner Pertama',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Medik Veteriner Muda',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Medik Veteriner Madya',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'POPT Pemula',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'POPT Pelaksana',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'POPT Mahir',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'POPT Penyelia',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'POPT Pertama',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'POPT Muda',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Analis Kepegawaian Penyelia',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Analis Kepegawaian Mahir',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Analis Kepegawaian Pelaksana',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Arsiparis Penyelia',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Arsiparis Mahir',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Arsiparis Pelaksana',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Pranata Humas Penyelia',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Pranata Humas Mahir',
            	'klasifikasi' => 'jft'
            ],
            [
            	'jabatan' => 'Pranata Humas Pelaksana',
            	'klasifikasi' => 'jft'
            ],
            [
                  'jabatan' => 'Calon POPT Pemula',
                  'klasifikasi' => 'nonjft'
            ],
            [
                  'jabatan' => 'Calon POPT Pelaksana',
                  'klasifikasi' => 'nonjft'
            ],
            [
                  'jabatan' => 'Calon POPT Pertama',
                  'klasifikasi' => 'nonjft'
            ],
            [
                  'jabatan' => 'Calon Paramedik Veteriner Pemula',
                  'klasifikasi' => 'nonjft'
            ],
            [
                  'jabatan' => 'Calon Paramedik Veteriner Pelaksana',
                  'klasifikasi' => 'nonjft'
            ],
            [
                  'jabatan' => 'Calon Medik Veteriner Pertama',
                  'klasifikasi' => 'nonjft'
            ],
        ]);
    }
}
