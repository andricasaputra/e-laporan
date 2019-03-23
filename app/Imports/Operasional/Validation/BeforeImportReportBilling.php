<?php

declare(strict_types = 1);

namespace App\Imports\Operasional\Validation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contracts\Operasional\ModelReportBillingInterface as Model;

class BeforeImportReportBilling extends BeforeImport
{
    /**
     * Set awal kebutuhan property validator
     *
     * @param App\Contracts\Operasional\ModelOperasionalInterface $model
     * @param Request $request
     * @return void
     */
    public function __construct(Model $model, Request $request)
    {
        // Pertama kita akan mengoper beberapa parameter yang dibutuhkan 
        // oleh class parent, sehingga kemudian kita dapat menggunakan
        // semua property dan method yang ada di class parent
        parent::__construct($model, $request, new ValidateLaporanBilling);
    }

    /**
     * Isi beberapa property yang akan kita gunakan lebih lanjut
     *
     * @return void
     */
    public function setValidationProperties()
    {
        $this->jenisLaporan    = $this->validator[0] ?? null;

        $this->jenisPermohonan = $this->validator[0] ?? null;

        $this->tanggalLaporan  = $this->validator[2] ?? null;
    }

    /**
     * Validasi laporan harus dari asli dari Simponi Barantan
     *
     * @return bool
     */
    protected function validateFileFromSimponi() : bool
    {
        // Mencegah laporan/file yang diupload kosong
        if (is_null($this->jenisLaporan) && is_null($this->tanggalLaporan)) {
            return false;
        }

        // Mencegah laporan/file yang diupload bukan kegiatan operasional
        if (stripos($this->jenisLaporan, 'LAPORAN BILLING') === false) {
            return false;
        }

        return true;
    }

    /**
     * Untuk validasi laporan yang diupload adalah bulanan dan bukan tahunan
     *
     * @return bool
     */
    protected function validateMustLaporanBulanan() : bool
    {
        // Ambil Bulan Dan Tahun Pada Laporan Di Row 3
        $tanggal = explode('s/d', strtolower($this->tanggalLaporan));

        $dari    = Carbon::parse(trim(str_ireplace('periode :', '', $tanggal[0])));

        $sampai  = Carbon::parse(trim($tanggal[1]));

        $this->tanggalLaporan  = $dari->startOfMonth();

        // Laporan harus dalam bulan yang sama
        if (! $dari->isSameMonth($sampai)) {

            $this->setWarning("Laporan Harus Dalam Format Bulanan");

            return false;
        } 

        // Laporan harus dimulai dari awal bulan
        if ($dari->startOfMonth() !== $dari) {

            $this->setWarning("Laporan Harus Mulai Dari Awal Bulan");

            return false;
        }

        // Laporan harus sampai akhir bulan
        if (! $sampai->isLastOfMonth()) {

            $this->setWarning("Laporan Harus Sampai Akhir Bulan");

            return false;
        }

        return true;
    }

    /**
     * Untuk menjalankan semua validasi yang diperlukan dan akan
     * dipergunakan / dipanggil dari class lain yang membutuhkan
     *
     * @return bool
     */
    public function runValidation() : bool
    {
        //  Validasi laporan harus asli dari aplikasi Simponi tanpa perubahan apapun
        if (! $this->validateFileFromSimponi()) {

            $this->setWarning("Format Laporan Yang Anda Unggah Bukan Merupakan Format Laporan Dari SIMPONI!");

            return false;
        }

        //  Validasi laporan harus berupa laporan bulanan
        if (! $this->validateMustLaporanBulanan()) {

            $this->setWarning("Hanya Laporan Bulanan Yang Boleh Diupload!");

            return false;
        }

        //  Validasi jenis karantina pada laporan harus sesuai dengan masing-masing halaman upload
    	if (! $this->validateJenisPormohonan()) {

    		$this->setWarning("Format Laporan Yang Anda Unggah Bukan Laporan {$this->jenisPermohonan}!");

    		return false;

    	}

    	return true;
    }

    /**
     * Untuk membuat mengambil tanggal laporan yang diambil dari 
     * data heading laporan excel
     *
     * @return string
     */
    public function getTanggalLaporan()
    {
        return $this->tanggalLaporan;
    }
}
