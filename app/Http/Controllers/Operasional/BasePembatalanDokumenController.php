<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wilker;
use App\Events\DataOperasionalUploadedEvent;

class BasePembatalanDokumenController extends AbstractBaseOperasional
{
    /**
     * Jika laporan berhasil diupload, method ini bertugas untuk
     * mengatur kebutuhan pesan notifikasi
     *
     * @return void
     */
    public function setNotificationProperties()
    {
        $this->table            =   $this->model->getTable();

        $this->wilker           =   Wilker::find($this->request->wilker_id);

        $this->usersToNotify    =   User::whereIn('id', [1, 2, 3, 4, 5])->get();

        $this->typeKarantina    =   explode('_', $this->table);

        $this->typeKarantina    =   end($this->typeKarantina);

        $this->linkNotify       =   $this->typeKarantina == 'kt' 
                                    ? route('kt.dokumen.data')
                                    : route('kh.dokumen.data');

        $this->notifyMessage    =   "Laporan {$this->request->jenis_permohonan} 
                                    {$this->wilker->getOriginal('nama_wilker')} 
                                    Tahun ". $this->tanggal->format('Y') ." 
                                    Sudah Terikirim";

        return $this;
    }

    /**
     * Jalankan event notifikasi
     *
     * @return void
     */
    public function fireUploadEvent()
    {
        new DataOperasionalUploadedEvent($this);
    }
}

