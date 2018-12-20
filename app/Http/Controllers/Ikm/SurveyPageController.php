<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Ikm;

use App\Models\User;
use App\Models\Ikm\Responden;
use App\Events\NewIkmSurveyEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyIkmForm;
use App\Http\View\Composers\Ikm\SurveyPageComposer;

class SurveyPageController extends Controller
{
    private $request;
    private $compose;

    public function __construct()
    {
        $this->compose = SurveyPageComposer::construct($this);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $this->compose->compose();

        return view('ikm.survey');  
    }

    public function home()
    {
        return view('ikm.home');
    }

    public function faq()
    {
        return view('ikm.faq');
    }

    public function surveyClosed()
    {
        return view('ikm.closed');
    }

    public function store(SurveyIkmForm $request)
    {
        $this->request = $request->all();

        $responden = $request->persistCreate();
        
        $this->setNotification();

        return redirect()->route('ikm.success', $responden);
    }

    public function success(Responden $responden)
    {
        if ($responden === null) return abort(404);

        $this->compose->composeSuccess($responden);

        return view('ikm.success');
    }

    public function cetak(Responden $responden)
    {
        if ($responden === null) return abort(404);

        $this->compose->composeCetak($responden);

        return view('ikm.cetak');             
    }

    public function userToNotify()
    {
        return User::userToNotify()->get();
    }

    public function setNotification()
    {
        new NewIkmSurveyEvent( 

            $this->userToNotify(), 
            $this->request['ikm_id'], 
            $this->request['layanan_id'], 
            route('intern.ikm.home.index') 

        );
    }
}
