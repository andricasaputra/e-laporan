<?php

declare(strict_types = 1);

namespace App\Imports\Operasional\Validation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contracts\Operasional\UseImportableInterface;

abstract class BeforeImport
{
    /**
     * Untuk menyimpan instance dari model
     *
     * @var App\Contracts\Operasional\ModelOperasionalInterface
     */
    protected $model;

    /**
     * Untuk menyimpan jenis karantina (KH/KT)
     *
     * @var string
     */
    protected $jenisKarantina;

    /**
     * Untuk menyimpan data wilker
     *
     * @var string
     */
    protected $wilker;

    /**
     * Untuk menyimpan data jenis laporan
     *
     * @var string
     */
	protected $jenisLaporan;

    /**
     * Untuk menyimpan data jenis permohonan
     *
     * @var string
     */
    protected $jenisPermohonan;

    /**
     * Untuk menyimpan data tanggal laporan
     *
     * @var string
     */
    protected $tanggalLaporan;

    /**
     * Untuk menyimpan isi/data laporan
     *
     * @var string
     */
    protected $laporanHasValue;

    /**
     * Untuk menyimpan data pesan kesalahan
     *
     * @var string
     */
	protected $warningContent;

    /**
     * Untuk menyimpan property data yang akan digunakan
     * oleh property yang lainnya didalam class ini
     *
     * @var array
     */
    protected $validator = [];

    /**
     * Set awal kebutuhan property validator
     *
     * @param object $model
     * @param App\Contracts\Operasional\UseImportableInterface $validator
     * @param Illuminate\Http\Request $request
     * @return void
     */
    protected function __construct(object $model, Request $request, UseImportableInterface $validator)
    {
    	$this->model     = $model;

        // Pertama kita akan merubah data menjadi bentuk collection
        // kemudian ambil satu saja data dari 8 baris awal pada laporan excel
        $this->validator = $validator->toCollection($request->file('filenya'))
                           ->flatten(1)
                           ->take(8)
                           ->map(function($datas){

                                return $datas->first();

                           });
    }

    /**
     * Isi beberapa property yang akan kita gunakan lebih lanjut
     *
     * @return void
     */
    abstract protected function setValidationProperties();

    /**
     * Untuk menjalankan semua validasi yang diperlukan dan akan
     * dipergunakan / dipanggil dari class lain yang membutuhkan
     *
     * @return bool
     */
    abstract protected function runValidation() : bool;

    /**
     * Untuk validasi laporan harus asli dari iqfast
     * dan tanpa perubahan apapun!
     *
     * @return bool
     */
    protected function validateFileFromIqfast() : bool
    {
        // Mencegah laporan/file yang diupload kosong
        if (is_null($this->jenisLaporan) && is_null($this->wilker) && is_null($this->jenisPermohonan)) {
            return false;
        }

        // Mencegah laporan/file yang diupload bukan kegiatan operasional
        if (stripos($this->jenisLaporan, 'LAPORAN KEGIATAN OPERASIONAL KARANTINA') === false) {
            return false;
        }

        return true;
    }

   	/**
     * Untuk validasi kesesuaian wilker user pengupload
     * dengan wilker pada laporan excel yang diupload 
     *
     * @return bool
     */
    protected function validateUserWilker() : bool
    {
    	// Ambil nama wilker dari laporan
    	$wilkerLaporan 	= explode(':', $this->wilker);

    	$wilkerLaporan 	= trim(end($wilkerLaporan));

    	// Ambil nama wilker dari user yang melakukan upload
    	$wilkerUser 	= auth()->user()->wilker()->get()->pluck('nama_wilker');

        // Superadmin bebas mengupload laporan semua wilker
        // superadmin() adalah helper -> lihat bootstrap/helpers.php
        if (superadmin()) {

            return true;
        }

    	// Cek Wilker User dengan wilker yang diupload pada laporan, 
        // apakah sesuai/tidak. Jika tidak sesuai maka tolak!
        if ($wilkerUser->contains($wilkerLaporan)) {

            return true;
        } 
         
        return false;
    }

    /**
     * Untuk validasi kesesuaian jenis karantina dari dokumen yang diupload dengan
     * jenis karantina dari user yang mengupload, ex : user tipe karantina hewan
     * tidak dapat mengupload laporan tipe karantina tumbuhan
     *
     * @return bool
     */
    protected function validateJenisKarantina() : bool
    {
        $this->jenisKarantina = $this->model->karantina;

        // Mencegah kesalahan dalam upload jenis karantina (KH/KT)
        if (strripos($this->jenisLaporan, $this->jenisKarantina) !== false) {
            return true;
        }

    	return false;
    }

    /**
     * Untuk validasi kesesuaian jenis permohonan dari dokumen yang diupload, ex : apabila
     * user berada dihalaman dokel maka hanya laporan dokel yang valid, selain itu tolak!
     *
     * @return bool
     */
    protected function validateJenisPormohonan() : bool
    {
    	$permohonan = $this->model->permohonan;

        // Mencegah kesalahan dalam upload jenis permohonan
        if (strripos($this->jenisPermohonan, $permohonan) !== false) {
            return true;
        }

        $this->jenisPermohonan = ucwords($permohonan);

        return false;
    }

    /**
     * Untuk validasi laporan yang diupload adalah bulanan dan bukan tahunan
     *
     * @return bool
     */
    protected function validateMustLaporanBulanan() : bool
    {
        // Mencegah untuk upload laporan tahunan
        if (strripos($this->tanggalLaporan, 'BULAN :') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Untuk validasi laporan yang diupload harus mempunyai isi/tidak boleh nihil
     *
     * @return bool
     */
    protected function validateLaporanHasValue() : bool
    {
        if (is_null($this->laporanHasValue)) {

            return false;
        }

        return true;
    }

    /**
     * Untuk menampung tipe dan konten dari pesan Kesalahan 
     * yang akan kita berikan kepada user setalah mengupload dokumen
     *
     * @param string $content
     * @return void
     */
	public function setWarning(string $content)
	{
		$this->warningContent = $content;

		return $this;
	}

    /**
     * Untuk mengambil pesan pesan Kesalahan
     *
     * @return string
     */
    public function getWarning()
    {
        return $this->warningContent;
    }

    /**
     * Untuk membuat mengambil tanggal laporan yang diambil dari 
     * data heading laporan excel
     *
     * @return string
     */
    public function getTanggalLaporan()
    {
        $ex    = explode(':', $this->tanggalLaporan);

        $bulan = preg_replace("/[^0-9]/", "", $ex[1]);

        $tahun = preg_replace("/[^0-9]/", "", end($ex));

        // pengecekan untuk tanggal pada laporan pembatalan dokumen,
        // karena pada laporan pembatalan dokumen, tanggal yang tertera hanya berupa tahun saja
        if ($tahun == $bulan) {

            return Carbon::parse($tahun)->startOfMonth();
        }

        return Carbon::parse("1-{$bulan}-{$tahun}")->startOfMonth();
    }
}
