<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Result;
use App\Models\Ikm\Responden;
use App\Models\Ikm\Question;
use App\Models\Ikm\Answer;

class Statistik extends Controller
{
    public function index()
    {
    	$questions =  Question::all();
    	return view('intern.ikm.statistik.index')
    	->with('result', $this->getRataRataNilai())
    	->with('questions', $questions);
    }

    private function getRataRataNilai()
    {
    	$result = Result::with(['answer:ikm_answer.id,nilai', 'question'])->get();

    	return $result->groupBy('question_id');

    }
}
