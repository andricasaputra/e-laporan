<?php 

namespace App\Repositories\Ikm;

use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Result;
use App\Traits\Repository;
use App\Models\Ikm\Question;
use App\Models\Ikm\Responden;
use App\Contracts\RepositoryInterface;

class HomeRepository implements RepositoryInterface
{
	use Repository;

	public function api(int $ikmId = null)
    {
        $ikmId 		= $ikmId ?? 1;

        $responden  = Responden::where('ikm_id', $ikmId)
        				->orderBy('created_at', 'desc')
        				->get();

        return  app('DataTables')::of($responden)->addIndexColumn()
                ->addColumn('action', function ($responden) use ($ikmId) {
                    return '
                    <a href="'.route('intern.ikm.home.edit', $responden->id).'" class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    <a href="'.route('intern.ikm.home.show', [$responden->id, $ikmId]).'" class="btn btn-xs btn-success">
                        <i class="glyphicon glyphicon-eye-open"></i> Detail
                    </a>
                    <a href="#" data-id = "'.$responden->id.'"  class="btn btn-danger btn-xs" id="deleteIkm">
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </a>';
                })
                ->make(true);
    }

    public function detailApi(int $id, int $ikmId)
    {
        $result =  Result::whereIn('responden_id', [$id])->where('ikm_id', $ikmId)->get();

        return app('DataTables')::of($result)
                ->addIndexColumn()
                ->make(true);
    }

    public function update($request, $responden)
    {
    	$answer 	= $request->except(['responden_id','submit','_method','_token']);

        $combined 	= Question::select('id')->get()->map(function($question){

            return $question->id;

        })->combine(collect($answer)->flatMap(function($value){

            return $value;

        }));

        foreach ($combined as $key => $value) {

            $result 			= Result::where('responden_id', $responden->id)
                        			->where('question_id', $key)
                        			->first();

            $result->answer_id 	= $value;

            $result->save();

        }

        return true;
    }

}