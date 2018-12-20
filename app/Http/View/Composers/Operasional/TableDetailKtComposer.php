<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Traits\TableOperasionalProperty;

class TableDetailKtComposer
{
    use TableOperasionalProperty;

    public $year;

    public function __construct($year = null)
    {
        $this->year = $year;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('titles', $this->tableTitleKt()); 

        $view->with('tahun', $this->year ?? date('Y'));
    }
}