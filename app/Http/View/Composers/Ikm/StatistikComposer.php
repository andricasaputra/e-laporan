<?php

namespace App\Http\View\Composers\Ikm;

use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Question;
use App\Http\Controllers\Ikm\StatistikController as Statistik;

class StatistikComposer
{
    /**
     * The answer repository implementation.
     *
     * @var AnswerRepository
     */
    protected static $data;

    public static function construct(Statistik $data)
    {
        static::$data = $data;

        return new static;       
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose()
    {
        view()->composer('intern.ikm.statistik.index', function ($view){

            $view->with('questions', Question::all());
            $view->with('ikm', Jadwal::select('id', 'keterangan')->get());
            $view->with('ikm_ket', Jadwal::select('keterangan')->whereId(static::$data->id)->first());
            $view->with('id', static::$data->id);  
            
        });     
    }
}