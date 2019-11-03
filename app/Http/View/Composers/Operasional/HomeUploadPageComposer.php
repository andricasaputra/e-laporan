<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;

class HomeUploadPageComposer
{
    use UsersTrait;

    public $year, $month, $wilker, $type;

    public function __construct(Request $request)
    {
<<<<<<< HEAD
        $this->type      = $request->type;

        $this->month     = $request->month;

        $this->wilker_id = $request->wilker_id;

        $this->year      = $request->year ?? date('Y');
=======
        $this->year         = $request->year;

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;

        $this->type         = $request->type;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
<<<<<<< HEAD
        $view->with('year', $this->year);

        $view->with('wilkers', $this->userWilker()); 
=======
        $view->with('wilkers', $this->setActiveUserWilker()); 

        $view->with('year', $this->year ?? date('Y'));
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}