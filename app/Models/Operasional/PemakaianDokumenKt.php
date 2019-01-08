<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class PemakaianDokumenKt extends Model
{
    use QueryScopeKtTrait;

	protected $table = 'v_pemakaian_dokumen_kt'; 
}
