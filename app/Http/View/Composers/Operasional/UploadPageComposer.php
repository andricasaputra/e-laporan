<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;

class UploadPageComposer
{
    use UsersTrait;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
<<<<<<< HEAD
        $view->with('user', $this->activeUser()); 

        $view->with('wilker', $this->userWilker());
=======
        $view->with('user', $this->setActiveUser()); 

        $view->with('wilker', $this->setActiveUserWilker());
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}