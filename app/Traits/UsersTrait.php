<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Wilker;

trait UsersTrait
{
	public function getUserId()
    {
        return auth()->user()->id;
    }

    public function getUserRoleId()
    {
        return auth()->user()->role()->first()->id;
    }

    public function setUserWilkerId(int $wilker_id)
    {
        return $wilker_id;
    }

    public function getUserWilkerName(int $wilker_id)
    {
        return Wilker::find($wilker_id)->nama_wilker;
    }

    public function setUserWilker()
    {
        $wilker_user = User::find($this->getUserId())->wilker->all();

        foreach ($wilker_user as $key => $value) {

            if (strpos($value->nama_wilker, '.') !== false) {

                $value->nama_wilker = str_replace('.', ' ', $value->nama_wilker);
            }

            $wilker[] = str_replace(' ', '', strtolower($value->nama_wilker));

        }

        return $wilker;
    }

    public function checkActiveUserIdAndRequestUserId(int $user_id)
    {
        if ($this->setActiveUser()->id !== $user_id) {

            session()->flash('warning','Unautorizhed User Detected!');

            return false;

        }

        return $user_id;
    }

    public function setActiveUser()
    {
        return User::whereId($this->getUserId())->first();
    }

    public function setActiveUserWilker()
    {
        return  $this->getUserRoleId() === 1 || $this->getUserRoleId() === 2

                ? Wilker::where('nama_wilker', '!=', 'Kantor induk')->get()

                : User::find($this->getUserId())->wilker;
    }

}