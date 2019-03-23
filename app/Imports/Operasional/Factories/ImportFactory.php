<?php

namespace App\Imports\Operasional\Factories;

use App\Contracts\Operasional\ModelPembatalanInterface;
use App\Contracts\Operasional\ModelOperasionalInterface;
use App\Imports\Operasional\Process\ImportLaporanBilling;
use App\Contracts\Operasional\ModelReportBillingInterface;
use App\Imports\Operasional\Process\ImportLaporanOperasional;
use App\Imports\Operasional\Process\ImportLaporanPembatalanDokumen;

class ImportFactory 
{
    public function initializeImportsType($model, $request, $tanggalLaporan = null)
    {
    	if ($model instanceof ModelOperasionalInterface) {

    		return new ImportLaporanOperasional($model, $request, $tanggalLaporan);

    	} elseif ($model instanceof ModelPembatalanInterface) {

    		return new ImportLaporanPembatalanDokumen($model, $request);

    	} elseif ($model instanceof ModelReportBillingInterface) {

    		return new ImportLaporanBilling($model, $request, $tanggalLaporan);

    	}

    	throw new \Exception("Jenis Laporan Tidak Ditemukan", 1);
    }
}
