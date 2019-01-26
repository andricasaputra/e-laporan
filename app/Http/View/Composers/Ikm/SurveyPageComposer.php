<?php

namespace App\Http\View\Composers\Ikm;

use App\Models\Ikm\Umur;
use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Layanan;
use App\Models\Ikm\Question;
use App\Models\Ikm\Pekerjaan;
use App\Models\Ikm\Responden;
use App\Models\Ikm\Pendidikan;
use App\Http\Controllers\Ikm\SurveyPageController as Survey;

class SurveyPageComposer
{
    /**
     * The answer repository implementation.
     *
     * @var Survey $data
     */
    protected static $data;

    /**
     * Class Setter, act like constructor
     *
     * @return this
     */
    public static function construct(Survey $data)
    {
        static::$data = $data;

        return new static;       
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose()
    {
        view()->composer('ikm.survey', function ($view){

            $is_open    = Jadwal::active()->first();
            $questions  = Question::with('answer')->get();
            $layanan    = Layanan::all();
            $umur       = Umur::all();
            $pendidikan = Pendidikan::all();
            $pekerjaan  = Pekerjaan::all();

            $view->with(compact('is_open', 'questions', 'layanan', 'umur', 'pendidikan', 'pekerjaan'));
            
        });     
    }

    /**
     * Bind data to the view cetak.
     *
     * @param Responden $responden
     * @return void
     */
    public function composeCetak(Responden $responden)
    {
        view()->composer('ikm.cetak', function ($view) use ($responden) {

            $answers            = $responden->answer;
            $question_answer    = Question::with('question_answer')->get();

            $view->with(compact('responden', 'answers', 'question_answer'));
            
        }); 
    }

    /**
     * Bind data to the view success.
     *
     * @param Responden $responden
     * @return void
     */
    public function composeSuccess(Responden $responden)
    {
        view()->composer('ikm.success', function ($view) use ($responden) {

            $view->with(compact('responden'));
            
        }); 
    }
}