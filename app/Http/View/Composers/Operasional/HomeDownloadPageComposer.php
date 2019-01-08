<?php

namespace App\Http\View\Composers\Operasional;

use App\Models\Wilker;
use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;

class HomeDownloadPageComposer
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
        $view->with('all_wilker', $this->setActiveUserWilker()); 

        $view->with('wilkers', Wilker::all());

        $view->with('year', $this->year ?? date('Y'));

        $view->with('pegawai', MasterPegawai::whereNotIn('id', [1, 2])->get());
    }
}