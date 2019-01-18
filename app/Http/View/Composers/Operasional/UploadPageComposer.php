<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;

class UploadPageComposer
{
    use UsersTrait;

    public function __construct()
    {
        // 
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', $this->setActiveUser()); 

        $view->with('wilker', $this->setActiveUserWilker());
    }
}