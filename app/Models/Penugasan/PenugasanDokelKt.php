<?php

namespace App\Models\Penugasan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Operasional\ModelPenugasanInterface;

class PenugasanDokelKt extends Model implements ModelPenugasanInterface
{
    use HasFactory, QueryScopePenugasan;

    protected $table = 'penugasan_dokel_kt';
    protected $guarded = ['id'];
    protected $hidden = ['no', 'updated_at'];

     /**
     * Untuk alias dari jenis permohonan untuk set argument route pada link notifikasi
     *
     * @var string
     */
    public $alias       = 'dokel';

    /**
     * Untuk menyematkan identitas permohonan yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
     *
     * @var string
     */
    public $permohonan  = 'domestik keluar';

    /**
     * Untuk menyematkan identitas karantina yang mewakili kelas ini
     * dipakai untuk pengecekan pada saat upload data dan lainnya
     *
     * @var string
     */
    public $karantina   = 'Karantina Tumbuhan';
}
