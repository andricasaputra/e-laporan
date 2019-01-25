<?php

namespace App\Models\Operasional\Dokumen;

use Illuminate\Database\Eloquent\Model;

class PenerimaanDokumenKt extends Model
{
    use QueryScopeDokumen;

    protected $table 	= 'penerimaan_dokumen_kt';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];
    protected $with     = ['wilker', 'user', 'dokumen'];
}
