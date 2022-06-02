<?php  

namespace App\Repositories;

use App\Models\SkpUser;
use Illuminate\Http\Request;
use App\Traits\Butir\ButirKegiatanPkt;

class EpersonalRepository
{
	use ButirKegiatanPkt;

	public $client, 
	$mlog, 
	$skpTahunan = [], 
	$kegiatan = [], 
	$target = [],
	$bulan,
	$tanggal,
	$tahun,
	$routeParams = [
    	"year" => NULL, 
        "month" => NULL, 
    ];

	protected $keyStart = 3;

	private $year, $month = NULL;

    public function __construct(Request $request)
	{
		$this->year  = $request->year ?? date('Y');

        $this->month = $request->month;

        $this->routeParams  = [
            "year" => $this->year, 
            "month" => $this->month, 
        ];
	}

	public function initialize()
	{
		$this->loginToEpersonal()->gotoMlog();

		return $this;
	}

	public function loginToEpersonal()
	{
		$this->client = app()->make('login');

		return $this;
	}

	public function store()
	{	
		try{

			foreach($this->skpTahunan as $tahunan):
	        	foreach($tahunan as  $bulanan):
	        		foreach($bulanan as $kegiatan):
	        			$insert = SkpUser::updateOrCreate(
		        			[
		        				'judul_kegiatan' => trim($kegiatan['judul_kegiatan']),
			        			'butir_kegiatan' => trim($kegiatan['butir_kegiatan']),
			        			'target' => trim($kegiatan['target']),
			        			'bulan' => $kegiatan['bulan'],
			        			'tahun' => trim($kegiatan['tahun']),
		        			], 
		        			[
		        				'user_id' => auth()->id(),
			        			'tanggal' => $kegiatan['tanggal'],

		        			]
		        		);
	        		endforeach;
	        	endforeach;
    		endforeach;

       		return response()->json([
                'success' => true,
                "message" => 'Berhasil mengambil Data SKP'
            ], 200);

       }catch(Illuminate\Database\QueryException $e){

       		return response()->json([
            	'success' => false,
	            'message' => 'Gagal Mengambil data SKP Error ' . $e->getMessage()
	        ], 500);
       		
       }

	}

	public function gotoMlog()
	{
		$crawler = $this->client->request('GET', 'https://epersonal.pertanian.go.id/sso');

        $jumperLogin = $crawler->filterXpath('//*[@id="modal-pilih-tahun-sinergi"]/div/div/div[2]/div/div[3]/a')->attr('href');

        $dashboard = $this->client->request('GET', $jumperLogin);

        $this->mLog = $this->client->request('GET', config('epersonal.uri.mlog'));

        return $this;
	}

	public function getSkp()
	{
        $tanggalSKP = $this->mLog->filter('select > option[selected]')->text();

        $this->judulKegiatan = $this->mLog->filter('h2')->each(function($h2){
        	return $h2->text();
        });

        $datas = $this->mLog->filter('table.table-rck')->each(function($t){

        	return $t->filter('tr')->each(function ($tr, $i) {

	            return $tr->filter('td')->each(function ($td, $i) {

	                return $td->text();
	            });
	        });

        });

       $this->setDatas($datas, $tanggalSKP);

       return $this;
       
	}

	protected function setDatas($datas, $tanggalSKP)
	{
		$now = date('Y');

        $ambilTahun = explode("s/d", $tanggalSKP);

        $ambilTahun = explode(" ", $ambilTahun[0]);

        $this->tahun = $ambilTahun[3] == $now ? $ambilTahun[3] : $now;

        $newdata = [];

        foreach($datas as $i => $data){
        	$newdata[$this->judulKegiatan[$i]] =  $data;
        }

         foreach($newdata as $judulkegiatan => $data):
        	foreach($data as $index => $d):
        		if (empty($d)) continue;
        		 $this->setValues($d, $judulkegiatan);
        	endforeach;
        endforeach;

        return $this;
	}

	protected function setValues($datas, $judulkegiatan)
	{
		try{


			if (count($datas) == 1) {

				$this->bulan = $datas[0] ?? '';
	    		
	    		$month = bulan_to_month($this->bulan);

	    		if (! empty($month)) {
	    			$this->tanggal = '01' . '-' . $month . '-' . $this->tahun;
	    			$this->tanggal = \Carbon\Carbon::parse($this->tanggal)->format('Y-m-d');
	    		}else{
	    			$this->tanggal = date('Y-m-d');
	    		}

			} 

		}catch(\Throwable $e){

			if($e instanceof \Carbon\Exceptions\InvalidFormatException){

			}
		}

		if(count($datas) == 10) {

			$this->kegiatan[$this->bulan] = $datas[1] ?? '';
	        $this->target[$this->bulan] = $datas[2] ?? '';

	        $this->skpTahunan[$judulkegiatan][$this->bulan][] = [

    			'user_id' => auth()->id(),
    			'tahun' => $this->tahun,
    			'bulan' => bulan_to_month($this->bulan),
    			'tanggal' => $this->tanggal,
    			'judul_kegiatan' => $judulkegiatan,
    			'butir_kegiatan' => $this->kegiatan[$this->bulan],
    			'target' => $this->target[$this->bulan]
				
			];
		}

	}

	public function tableData($year = null, $month = null)
    {
        $params = [$year, $month];

        $skp    = SkpUser::sortTableDetail($params)->with('pegawai')->whereUserId(auth()->id())->get();

        return datatables($skp)
            ->addIndexColumn() 
            ->editColumn('user_id', function ($user) {
                  return $user->pegawai->nama;
           })
            ->editColumn('bulan', function($data){
            	return month_to_bulan($data->bulan);
            })
            ->make(true);

         return $this;
    }

    public function getRouteParams()
	{
		return $this->routeParams;
	}
}