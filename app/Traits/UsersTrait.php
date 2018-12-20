<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Wilker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

trait UsersTrait
{
	public function getUserId()
    {
        return Auth::user()->id;
    }

    public function getUserRoleId()
    {
        return Auth::user()->role()->first()->id;
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

            Session::flash('warning','Unautorizhed User Detected!');

            return false;

        }

        return $user_id;
    }

    public function setActiveUser()
    {
        $user = User::whereId($this->getUserId())->first();

        return $user;
    }

    public function setActiveUserWilker()
    {
        $wilker = $this->getUserRoleId() === 1 || $this->getUserRoleId() === 2

                ? Wilker::where('nama_wilker', '!=', 'Kantor induk')->get()

                : User::find($this->getUserId())->wilker;

        return $wilker;
    }
}