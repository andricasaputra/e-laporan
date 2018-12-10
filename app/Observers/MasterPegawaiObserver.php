<?php

namespace App\Observers;

use Illuminate\Http\Request;
use App\Events\UpdatePegawai;
use App\Models\MasterPegawai;
use App\Events\RegisterPegawai;

class MasterPegawaiObserver
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Handle the master pegawai "created" event.
     *
     * @param  \App\MasterPegawai  $masterPegawai
     * @return void
     */
    public function created(MasterPegawai $masterPegawai)
    {
        event(new RegisterPegawai($masterPegawai, $this->request)); 
    }

    /**
     * Handle the master pegawai "updated" event.
     *
     * @param  \App\MasterPegawai  $masterPegawai
     * @return void
     */
    public function updated(MasterPegawai $masterPegawai)
    {
        event(new UpdatePegawai($masterPegawai, $this->request)); 
    }

}
