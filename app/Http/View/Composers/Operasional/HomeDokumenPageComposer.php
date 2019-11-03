<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;

class HomeDokumenPageComposer
{
    use UsersTrait;

    public $year, $month, $wilker, $type;

    public function __construct(Request $request)
    {
<<<<<<< HEAD
        $this->type      = $request->type;

        $this->month     = $request->month;

         $this->year     = $request->year ?? date('Y');

        $this->wilker_id = $request->wilker_id ?? $this->wilkerId();
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
        $view->with('tahun', $this->year);

        $view->with('bulan', $this->month);

        $view->with('user', $this->activeUser()); 

        $view->with('wilkers', $this->userWilker()); 

        $view->with('userWilker', $this->wilker_id);
=======
        $view->with('user', $this->setActiveUser()); 

        $view->with('wilkers', $this->setActiveUserWilker()); 

        $view->with('userWilker', $this->wilker_id ?? auth()->user()->wilker->first()->id);

        $view->with('tahun', $this->year ?? date('Y'));

        $view->with('bulan', $this->month);
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}