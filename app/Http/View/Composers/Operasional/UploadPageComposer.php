<?php

namespace App\Http\View\Composers\Operasional;

use Illuminate\View\View;
use App\Http\Controllers\Operasional\BaseOperasionalController;

class UploadPageComposer
{
    public $data;

    public function __construct(BaseOperasionalController $data)
    {
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
        $view->with('user', $this->data->setActiveUser()); 

        $view->with('wilker', $this->data->setActiveUserWilker());
    }
}