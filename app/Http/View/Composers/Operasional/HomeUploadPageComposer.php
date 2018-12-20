<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Support\Facades\Auth;

class HomeUploadPageComposer
{
    use UsersTrait;

    public $year;

    public function __construct($year = null)
    {
        $this->year = $year;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('all_wilker', $this->setActiveUserWilker()); 

        $view->with('wilker', Auth::user()->wilker->first());

        $view->with('year', $this->year ?? date('Y'));
    }
}