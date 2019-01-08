<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class PemakaianDokumenKh extends Model
{
    use QueryScopeKhTrait;

	protected $table = 'v_pemakaian_dokumen_kh'; 
}
