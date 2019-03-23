<?php

namespace App\Imports\Operasional\Validation;

use Maatwebsite\Excel\Concerns\Importable;
use App\Contracts\Operasional\UseImportableInterface;

class ValidateLaporanBilling implements UseImportableInterface
{
	/*
    |--------------------------------------------------------------------------
    | Class Info
    |--------------------------------------------------------------------------
    | Class ini dipakai pada App\Imports\Operasional\BeforeImportOperasional
    | untuk mengambil collection dari judul (5 row/baris awal) laporan operasional
    | e.g jenis permohonan, jenis karantina, upt/wilker, dan tanggal laporan untuk divalidasi
    |
    */

	use Importable;
}
