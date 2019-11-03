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
    /**
     * For save Request Instance
     *
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * For save SurveyPageComposer instance
     *
     * @var App\Http\View\Composers\Ikm\SurveyPageComposer
     */
    private $compose;

    /**
     * Set Composer For views
     *
     * @return void
     */
    public function __construct()
    {
        $this->compose = SurveyPageComposer::construct($this);
    }
    
    /**
     * Display a survey page.
     *
     * @return void
     */
    public function index()
    { 
        $this->compose->compose();

        return view('ikm.survey');  
    }

    /**
     * Display landing page
     *
     * @return void
     */
    public function home()
    {
        return view('ikm.home');
    }

    /**
     * Display FAQ page
     *
     * @return void
     */
    public function faq()
    {
        return view('ikm.faq');
    }

    /**
     * Display closed IKM page
     *
     * @return void
     */
    public function surveyClosed()
    {
        return view('ikm.closed');
    }

    /**
     * store survey IKM result
     *
     * @param SurveyIkmForm $request
     * @return void
     */
    public function store(SurveyIkmForm $request)
    {
        $this->request  = $request->all();

        $responden      = $request->persistCreate();

        if ($responden === false) {
           return redirect()->route('ikm.survey')->withWarning('terdapat pertanyaan yang belum dijawab, mohon untuk lebih teliti saat mengisi survey');
        }
        
        $this->setNotification();

        return redirect()->route('ikm.success', $responden);
    }

    /**
     * Generate success page if survey done
     *
     * @param App\Models\Ikm\Responden $responden
     * @return void
     */
    public function success(Responden $responden)
    {
        if ($responden === null) return abort(404);

        $this->compose->composeSuccess($responden);

        return view('ikm.success');
    }

    /**
     * For print survey IKM result
     *
     * @param App\Models\Ikm\Responden $responden
     * @return void
     */
    public function cetak(Responden $responden)
    {
        if ($responden === null) return abort(404);

        $this->compose->composeCetak($responden);

        return view('ikm.cetak');             
    }

    /**
     * Set user to notify when theres new IKM responden
     *
     * @return void
     */
    public function userToNotify()
    {
        return User::userToNotify();
    }

    /**
     * Set notifications properties and pass them to NewIkmSurveyEvent class
     *
     * @return void
     */
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
