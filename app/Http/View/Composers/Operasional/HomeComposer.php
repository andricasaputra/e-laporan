<?php

namespace App\Http\View\Composers\Operasional;

<<<<<<< HEAD
use Illuminate\View\View;
use App\Traits\UsersTrait;

class HomeComposer
{
    use UsersTrait;

=======
use App\Models\Wilker;
use Illuminate\View\View;

class HomeComposer
{
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
<<<<<<< HEAD
        $view->with('wilkers', $this->notUpt());
=======
        $view->with('wilkers', Wilker::where('id', '!=', 1)->get());
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}