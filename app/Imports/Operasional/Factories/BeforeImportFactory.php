<?php

namespace App\Imports\Operasional\Factories;

use App\Contracts\Operasional\ModelPembatalanInterface;
use App\Contracts\Operasional\ModelOperasionalInterface;
use App\Contracts\Operasional\ModelReportBillingInterface;
use App\Imports\Operasional\Validation\BeforeImportOperasional;
use App\Imports\Operasional\Validation\BeforeImportReportBilling;
use App\Imports\Operasional\Validation\BeforeImportPembatalanDokumen;

class BeforeImportFactory 
{
    public function initializeValidationType($model, $request)
    {
    	if ($model instanceof ModelOperasionalInterface) {

    		return new BeforeImportOperasional($model, $request);

    	} elseif ($model instanceof ModelPembatalanInterface) {

    		return new BeforeImportPembatalanDokumen($model, $request);

    	} elseif ($model instanceof ModelReportBillingInterface) {

    		return new BeforeImportReportBilling($model, $request);

    	}

    	throw new \Exception("Jenis Laporan Tidak Ditemukan", 1);
    }
}
