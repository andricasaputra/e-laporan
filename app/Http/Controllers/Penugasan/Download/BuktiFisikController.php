<?php

namespace App\Http\Controllers\Penugasan\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuktiFisikController extends Controller
{
    protected $year, $month, $wilker;

    public function __construct(Request $request)
    {
        $this->year = $request->year ?? date('Y');
        $this->month = $request->month;
        $this->wilker = $request->wilker_id;
    }

    public function asPdf()
    {
        $pdf = app()->make('snappy.pdf.wrapper');
        $pdf->loadView('intern.penugasan.kt.download.pdf.bukti_fisik');
        return $pdf->inline();
    }
}
