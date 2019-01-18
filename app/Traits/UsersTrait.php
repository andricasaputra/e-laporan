<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Wilker;

trait UsersTrait
{
    /**
     * Get active user id
     *
     * @return int
     */
	public function getUserId()
    {
        return auth()->user()->id;
    }

    /**
     * Get active user role id
     *
     * @return int
     */
    public function getUserRoleId()
    {
        return auth()->user()->role()->first()->id;
    }

    /**
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

                ? Wilker::where('id', '!=', 1)->get()

                : User::find($this->getUserId())->wilker;
    }

}