<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\TableOperasionalProperty;
use App\Contracts\BaseOperasionalInterface;
use App\Http\Controllers\Operasional\DokelKhController;
use App\Http\Controllers\Operasional\BaseOperasionalController;

class TableDetailKhComposer
{
    use TableOperasionalProperty;

    public $year;
    public $month;
    public $wilker_id;

    public function __construct(Request $request)
    {
        $this->year         = $request->route()->parameter('year') ?? date('Y');

        $this->month        = $request->route()->parameter('month');

        $this->wilker_id    = $request->route()->parameter('wilker_id');

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('titles', $this->tableTitleKh()); 

        $view->with('tahun', $this->year);
    }
}