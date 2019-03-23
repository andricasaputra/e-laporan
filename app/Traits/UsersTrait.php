<?php

namespace App\Traits;

use App\Models\Wilker;
use App\Models\MasterPegawai;

trait UsersTrait
{
    /**
     * Mendapatkan user id
     *
     * @return int
     */
	public function userId()
    {
        return auth()->user()->id;
    }

    /**
     * Mendapatkan user role id
     *
     * @return int
     */
    public function roleId()
    {
        return auth()->user()->role()->first()->id;
    }

    /**
     * Mendapatkan user wilker id
     *
     * @return int
     */
    public function wilkerId()
    {
        return auth()->user()->wilker()->first()->id;
    }

    /**
     * Mendapatkan user yang sedang aktif
     *
     * @return array
     */
    public function activeUser()
    {
        return auth()->user();
    }

    /**
     * Mendapatkan wilker dari user
     *
     * @return array
     */
    public function userWilker()
    {
        return superadmin() || admin() ? Wilker::all() : auth()->user()->wilker()->get();
    }

    /**
     * Mendapatkan semua user yang bukan admin
     *
     * @return array
     */
    public function nonAdmin()
    {
        return MasterPegawai::whereNotIn('id', [1, 2])->get();
    }

    /**
     * Mendapatkan semua wilker kecuali UPT Induk
     *
     * @return array
     */
    public function notUpt()
    {
        return Wilker::where('id', '!=', 1)->get();
    }

}