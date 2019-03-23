<?php

declare(strict_types = 1);

namespace App\Imports\Operasional\Validation;

use Illuminate\Http\Request;
use App\Contracts\Operasional\ModelPembatalanInterface as Model;

class BeforeImportPembatalanDokumen extends BeforeImport
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
        // Pertama kita akan mengirim beberapa argument yang dibutuhkan 
        // oleh class parent, sehingga kemudian kita dapat menggunakan
        // semua property dan method yang ada di class parent
        parent::__construct($model, $request, new ValidateLaporanPembatalanDokumen);
    }

    /**
     * Isi beberapa property yang akan kita gunakan lebih lanjut
     *
     * @return void
     */
    public function setValidationProperties()
    {
        $this->jenisLaporan    = $this->validator[0] ?? null;

        $this->wilker          = $this->validator[1] ?? null;

        $this->jenisPermohonan = $this->validator[0] ?? null;

        $this->tanggalLaporan  = $this->validator[3] ?? null;
    }

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
        if (stripos($this->jenisLaporan, 'LAPORAN PEMBATALAN DOKUMEN') === false) {
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
        //  Validasi laporan harus asli dari aplikasi Iqfast tanpa perubahan apapun
        if (! $this->validateFileFromIqfast()) {

            $this->setWarning("Harap Sesuaikan Format Laporan Yang Anda Unggah Dengan Format Dari IQFAST!");

            return false;
        }

        //  Validasi wilker pada laporan harus sesuai dengan wilker user yang mengupload
    	if (! $this->validateUserWilker()) {

    		$this->setWarning("Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!");

        	return false;
    	}

        //  Validasi jenis karantina pada laporan harus sesuai dengan jenis karantina user yang mengupload
    	if (! $this->validateJenisKarantina()) {

    		$this->setWarning("Format Laporan Yang Anda Unggah Bukan Bukan Kegiatan {$this->jenisKarantina}!");

    		return false;

    	}

        //  Validasi jenis karantina pada laporan harus sesuai dengan masing-masing halaman upload
    	if (! $this->validateJenisPormohonan()) {

    		$this->setWarning("Format Laporan Yang Anda Unggah Bukan Laporan {$this->jenisPermohonan}!");

    		return false;

    	}

    	return true;
    }

}
