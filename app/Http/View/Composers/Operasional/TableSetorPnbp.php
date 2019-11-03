<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Traits\Operasional\TableOperasionalHeader;

class TableSetorPnbp
{
	use UsersTrait, TableOperasionalHeader;

    public $year, $month, $wilker_id;

    public function __construct(Request $request)
    {
        $this->month     = $request->month;

        $this->year      = $request->year ?? date('Y');

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

        $view->with('wilkers', $this->notUpt());

        $view->with('userWilker', $this->wilker_id);

        $view->with('titles', $this->tableHeaderSetorBilling()); 
    }
}