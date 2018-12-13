<?php

namespace App\Http\View\Composers\Ikm;

use Illuminate\View\View;
use App\Repositories\Ikm\GrafikRepository;
use App\Http\Controllers\Ikm\Grafik;

class GrafikComposer
{
    /**
     * The answer repository implementation.
     *
     * @var AnswerRepository
     */
    protected $data;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(GrafikRepository $data)
    {
        dd($data->ikm);
        $this->data = $data;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // $view->with(compact('ikm'))->with('id', $id)->with('ikm_ket', $ikm_ket); 
    }
}