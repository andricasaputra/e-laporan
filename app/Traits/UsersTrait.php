<?php

namespace App\Traits;

<<<<<<< HEAD
use App\Models\Wilker;
use App\Models\MasterPegawai;
=======
use App\Models\User;
use App\Models\Wilker;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

trait UsersTrait
{
    /**
<<<<<<< HEAD
     * Mendapatkan user id
     *
     * @return int
     */
	public function userId()
=======
     * Get active user id
     *
     * @return int
     */
	public function getUserId()
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return auth()->user()->id;
    }

    /**
<<<<<<< HEAD
     * Mendapatkan user role id
     *
     * @return int
     */
    public function roleId()
=======
     * Get active user role id
     *
     * @return int
     */
    public function getUserRoleId()
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return auth()->user()->role()->first()->id;
    }

    /**
<<<<<<< HEAD
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
=======
     * Set active user wilker id
     *
     * @param int $wilkerId
     * @return int
     */
    public function setUserWilkerId(int $wilkerId)
    {
        return $wilkerId;
    }

    /**
     * Set active user wilker name
     *
     * @param int $wilkerId
     * @return string
     */
    public function getUserWilkerName(int $wilkerId)
    {
        return Wilker::find($wilkerId)->nama_wilker;
    }

    /**
     * Set active user wilker, satu user dapat memiliki beberapa wilker
     *
     * @return array
     */
    public function setUserWilker()
    {
        $wilkerUser = User::find($this->getUserId())->wilker->all();

        foreach ($wilkerUser as $key => $value) {

            $value->nama_wilker = str_replace('.', ' ', $value->nama_wilker);

            $wilker[] = str_replace(' ', '', strtolower($value->nama_wilker));

        }

        return $wilker;
    }

    /**
     * Untuk mengecek active user dengan user yang melakukan request via upload data laporan
     *
     * @return int|bool
     */
    public function checkActiveUserIdAndRequestUserId(int $userId)
    {
        if ($this->setActiveUser()->id !== $userId) {

            session()->flash('warning','Unautorizhed User Detected!');

            return false;

        }

        return $userId;
    }

    /**
     * Set active user
     *
     * note : ini method yang mubazir :)
     * @return array
     */
    public function setActiveUser()
    {
        return User::whereId($this->getUserId())->first();
    }

    /**
     * Set active user wilker
     *
     * note : ini method yang mubazir :)
     * @return array
     */
    public function setActiveUserWilker()
    {
        return  $this->getUserRoleId() === 1 || 
                $this->getUserRoleId() === 2 ||
                $this->getUserRoleId() === 3

                ? Wilker::all()

                : User::find($this->getUserId())->wilker;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

}