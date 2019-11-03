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
<<<<<<< HEAD
=======
        $view->with('roles', Role::where('id', '!=', 1)->get()); 

>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        $view->with('wilkers', Wilker::all());

        $view->with('jabatan', Jabatan::all());
        
        $view->with('golongan', Golongan::all());
<<<<<<< HEAD

        $view->with('roles', Role::where('id', '!=', 1)->get());
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}