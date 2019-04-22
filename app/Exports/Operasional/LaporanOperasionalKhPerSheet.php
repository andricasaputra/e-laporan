<?php  

namespace App\Exports\Operasional;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Exports\Operasional\Factories\StyleFactory;
use App\Exports\Operasional\Style\LaporanOperasionalStyle;

class LaporanOperasionalKhPerSheet extends AbstractLaporanPerSheet implements FromView, WithTitle, WithEvents, ShouldAutoSize
{
    /**
    * Set property awal pada class parent
    *
    * @param Illuminate\Http\Request $request
    * @param App\Repositories\Operasional\DataOperasionalKhRepository|DataOperasionalKhRepository $repository
    * @param string $permohonan
    * @return void
    */
    public function __construct(Request $request, $repository, $permohonan)
    {
        parent::__construct($request, $repository, $permohonan);
    }

    /**
     * @return Builder
     */
    public function view() : View
    {
        return view('intern.operasional.kh.download.laporan_operasional_excel')->withDatas($this->data->sentDatasToView());
    }

    /**
     * @return string
     */
    public function title() : string
    {
        return $this->data->permohonan;
    }

    /**
     * @return array
     */
    public function registerEvents() : array
    {
        return [

            AfterSheet::class => function(AfterSheet $event) {

                $factory = (new StyleFactory)->initStyle($this->request, $event->sheet, $this->totalData, $this->totalKetData);
                
                $factory->applyStyle();

            }, 
        
        ];
    }
}