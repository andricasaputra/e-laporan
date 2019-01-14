<?php

namespace App\Http\View\Composers\Operasional;

use App\Models\Wilker;
use Illuminate\View\View;

class HomeComposer
{
    public function __construct()
    {
        // 
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('wilkers', Wilker::where('id', '!=', 1)->get());
    }
}