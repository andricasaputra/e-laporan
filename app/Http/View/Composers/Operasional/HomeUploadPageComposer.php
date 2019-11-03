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
        $this->type      = $request->type;

        $this->month     = $request->month;

        $this->wilker_id = $request->wilker_id;

        $this->year      = $request->year ?? date('Y');
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('year', $this->year);

        $view->with('wilkers', $this->userWilker()); 
    }
}