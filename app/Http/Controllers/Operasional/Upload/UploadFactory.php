<?php

namespace App\Http\Controllers\Operasional\Upload;

use Illuminate\Http\Request;
use App\Contracts\ModelPembatalanInterface;
use App\Contracts\ModelOperasionalInterface;
use App\Contracts\ModelReportBillingInterface;

class UploadFactory
{
    public function initializeUploadType($model, Request $request)
    {
    	if ($model instanceof ModelOperasionalInterface) {

    		return new UploadLaporanOperasional($model, $request);

    	} elseif ($model instanceof ModelPembatalanInterface) {

    		return new UploadLaporanPembatalan($model, $request);

    	} elseif ($model instanceof ModelReportBillingInterface) {

    		return new UploadLaporanBilling($model, $request);

    	}

    	throw new Exception("Jenis Laporan Tidak Ditemukan", 1);
    }
}
