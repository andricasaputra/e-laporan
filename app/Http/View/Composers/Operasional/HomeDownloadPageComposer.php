<?php

namespace App\Http\View\Composers\Operasional;

<<<<<<< HEAD
use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;

class HomeDownloadPageComposer
{
    use UsersTrait;

=======
use App\Models\Wilker;
use Illuminate\View\View;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;

class HomeDownloadPageComposer
{
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    public $year, $month, $wilker, $type;

    public function __construct(Request $request)
    {
<<<<<<< HEAD
        $this->type      = $request->type;

        $this->month     = $request->month;

        $this->wilker_id = $request->wilker_id;

        $this->year      = $request->year ?? date('Y');
=======
        $this->year         = $request->year;

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;

        $this->type         = $request->type;
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
        $view->with('year', $this->year);

        $view->with('pegawai', $this->nonAdmin());

         $view->with('wilkers', $this->userWilker());
=======
        $view->with('wilkers', Wilker::all());

        $view->with('year', $this->year ?? date('Y'));

        $view->with('pegawai', MasterPegawai::whereNotIn('id', [1, 2])->get());
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}