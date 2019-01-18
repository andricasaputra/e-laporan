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
        $view->with('wilkers', $this->setActiveUserWilker()); 

        $view->with('year', $this->year ?? date('Y'));
    }
}