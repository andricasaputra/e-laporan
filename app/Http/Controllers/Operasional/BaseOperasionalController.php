<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wilker;
use App\Events\DataOperasionalUploadedEvent;

class BaseOperasionalController extends AbstractBaseOperasional
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

        $this->usersToNotify    =   User::userToNotify();

        $this->typeKarantina    =   explode('_', $this->table);

        $this->typeKarantina    =   end($this->typeKarantina);

        $this->linkNotify       =   route($this->typeKarantina .'.view.page.detail.bigtable.'. $this->model->alias,
                                       [
                                        Carbon::parse($this->tanggal)->format('Y'),
                                        Carbon::parse($this->tanggal)->format('m'),
                                        $this->request->wilker_id
                                       ]
                                    );

        $this->notifyMessage    =   "Laporan {$this->request->jenis_permohonan} 
                                    {$this->model->karantina} {$this->wilker->getOriginal('nama_wilker')} 
                                    Bulan ". bulan(Carbon::parse($this->tanggal)->format('m')) ." 
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

