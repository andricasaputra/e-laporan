<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operasional\DokelKt as Operasional;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Controller
{
    public function export() 
    {
        $Datas = Operasional::all()->toArray();
        return Excel::create('Datas', function($excel) use ($Datas) {
            $excel->sheet('Data Details', function($sheet) use ($Datas)
            {
                $sheet->fromArray($Datas);
            });
        })->download('xlsx');
    }
}
