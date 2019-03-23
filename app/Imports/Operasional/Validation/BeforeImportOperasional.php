<?php

declare(strict_types = 1);

namespace App\Imports\Operasional\Validation;

use Illuminate\Http\Request;
use App\Contracts\Operasional\ModelOperasionalInterface as Model;

class BeforeImportOperasional extends BeforeImport
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
        parent::__construct($model, $request, new ValidateLaporanOperasional);
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

        $this->jenisPermohonan = $this->validator[2] ?? null;

        $this->tanggalLaporan  = $this->validator[3] ?? null;
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

            $this->setWarning("Format Laporan Yang Anda Unggah Bukan Merupakan Format Laporan Bulanan Dari IQFAST!");

            return false;
        }

        //  Validasi laporan harus berupa laporan bulanan
        if (! $this->validateMustLaporanBulanan()) {

            $this->setWarning("Hanya Laporan Bulanan Yang Boleh Diupload!");

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
