<?php  

namespace App\Repositories;

use Illuminate\Http\Request;

class PenugasanRepository
{
	private $year, $month = NULL, $wilker_id = NULL;

    public $routeParams = [
    	"year" => NULL, 
        "month" => NULL, 
         "wilker" => NULL
    ];

	public function __construcr(Request $request)
	{
		$this->year         = $request->year ?? date('Y');

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;

        $this->routeParams  = [
            "year" => $this->year, 
            "month" => $this->month, 
            "wilker" => $this->wilker_id
        ];
	}

	public function getRouteParams()
	{
		return $this->routeParams;
	}

}
