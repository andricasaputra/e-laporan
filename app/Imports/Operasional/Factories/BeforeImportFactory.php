<?php

namespace App\Imports\Operasional\Factories;

use App\Contracts\Operasional\ModelPembatalanInterface;
use App\Contracts\Operasional\ModelOperasionalInterface;
use App\Contracts\Operasional\ModelReportBillingInterface;
use App\Contracts\Operasional\ModelPenugasanInterface;
use App\Imports\Operasional\Validation\BeforeImportOperasional;
use App\Imports\Operasional\Validation\BeforeImportReportBilling;
use App\Imports\Operasional\Validation\BeforeImportPembatalanDokumen;
use App\Imports\Operasional\Validation\BeforeImportPenugasan;

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

    	} elseif ($model instanceof ModelPenugasanInterface) {

            return new BeforeImportPenugasan($model, $request);

        } 

    	throw new \Exception("Jenis Laporan Tidak Ditemukan", 1);
    }
}
