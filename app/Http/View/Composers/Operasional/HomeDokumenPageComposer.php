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
        $this->type      = $request->type;

        $this->month     = $request->month;

         $this->year     = $request->year ?? date('Y');

        $this->wilker_id = $request->wilker_id ?? $this->wilkerId();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tahun', $this->year);

        $view->with('bulan', $this->month);

        $view->with('user', $this->activeUser()); 

        $view->with('wilkers', $this->userWilker()); 

        $view->with('userWilker', $this->wilker_id);
    }
}