<?php

namespace App\Http\View\Composers\Operasional;

<<<<<<< HEAD
use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Traits\Operasional\TableOperasionalHeader;

class TableSetorPnbp
{
	use UsersTrait, TableOperasionalHeader;
=======
use App\Models\Wilker;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\TableOperasionalProperty;

class TableSetorPnbp
{
	use TableOperasionalProperty;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

    public $year, $month, $wilker_id;

    public function __construct(Request $request)
    {
<<<<<<< HEAD
        $this->month     = $request->month;

        $this->year      = $request->year ?? date('Y');

        $this->wilker_id = $request->wilker_id ?? $this->wilkerId();
=======
        $this->year         = $request->year;

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;
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

        $view->with('wilkers', $this->notUpt());

        $view->with('userWilker', $this->wilker_id);

        $view->with('titles', $this->tableHeaderSetorBilling()); 
=======
        $view->with('wilkers', Wilker::where('id', '!=', 1)->get());

        $view->with('titles', $this->tableHeaderSetorBilling()); 

        $view->with('tahun', $this->year ?? date('Y'));

        $view->with('bulan', $this->month);

        $view->with('userWilker', $this->wilker_id ?? auth()->user()->wilker->first()->id);
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}