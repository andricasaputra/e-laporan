<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Models\Wilker;

class PenugasanComposer
{
    use UsersTrait;

    public $year, $month, $wilker_id;

    public function __construct(Request $request)
    {
        $this->year      = $request->year ?? date('Y');

        $this->month     = $request->month ?? str_replace('0', '', date('m'));
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

        $view->with('month', $this->month);

        $view->with('wilkers', $this->notUpt());

        $view->with('userWilker', admin() ? Wilker::all() : auth()->user()->wilker);
    }
}