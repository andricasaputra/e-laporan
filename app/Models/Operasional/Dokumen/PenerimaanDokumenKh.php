<?php

namespace App\Models\Operasional\Dokumen;

use Illuminate\Database\Eloquent\Model;

class PenerimaanDokumenKh extends Model
{
    use QueryScopeDokumen;

    protected $table 	= 'penerimaan_dokumen_kh';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];
    protected $with     = ['wilker', 'user', 'dokumen'];
}
