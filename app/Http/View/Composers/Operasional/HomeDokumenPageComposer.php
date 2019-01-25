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
        $this->year         = $request->year;

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;

        $this->type         = $request->type;
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

        $view->with('wilkers', $this->setActiveUserWilker()); 

        $view->with('userWilker', $this->wilker_id ?? auth()->user()->wilker->first()->id);

        $view->with('tahun', $this->year ?? date('Y'));

        $view->with('bulan', $this->month);
    }
}