<?php

namespace App\Http\View\Composers\Operasional;

use App\Models\Wilker;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\TableOperasionalProperty;
use App\Contracts\BaseOperasionalInterface;
use App\Http\Controllers\Operasional\DokelKhController;
use App\Http\Controllers\Operasional\BaseOperasionalController;

class TableDetailKhComposer
{
    use TableOperasionalProperty;

    public $year, $month, $wilker_id;

    public function __construct(Request $request)
    {
        $this->year         = $request->year;

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('wilkers', Wilker::where('id', '!=', 1)->get());

        $view->with('titles', $this->tableTitleKh()); 

        $view->with('tahun', $this->year ?? date('Y'));

        $view->with('bulan', $this->month);

        $view->with('userWilker', $this->wilker_id ?? auth()->user()->wilker->first()->id);
    }
}