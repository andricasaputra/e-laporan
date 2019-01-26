<?php

namespace App\Http\View\Composers;

use App\Models\Role;
use App\Models\Wilker;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\View\View;

class UsersComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('roles', Role::where('id', '!=', 1)->get()); 

        $view->with('wilkers', Wilker::all());

        $view->with('jabatan', Jabatan::all());
        
        $view->with('golongan', Golongan::all());
    }
}