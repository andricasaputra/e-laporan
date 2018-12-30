<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use App\Events\OperasionalRollbackEvent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OperasionalRollbackListener
{
    private $model;
    private $tableName;
    private $namespace = 'App\\Models\\Operasional\\';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getModelName($table)
    {
        $class = Str::studly(Str::singular($table));

        if (! is_null($class)) {

            if (! is_subclass_of($this->namespace . $class, 'Illuminate\Database\Eloquent\Model')) {

                 return false;

            }

            $model = $this->namespace . $class;

            $operasionalClass = new $model;

            return $this->model = $operasionalClass->getTable() == $this->tableName 
                                ? $operasionalClass 
                                : false;

        }

        return false;
    }

    /**
     * Handle the event.
     *
     * @param  OperasionalRollbackEvent  $event
     * @return void
     */
    public function handle(OperasionalRollbackEvent $event)
    {
        $this->tableName    = $event->type;

        if ( $this->getModelName($this->tableName) ) {

            $operasional    =   $this->model->whereIn('bulan', [$event->bulan])
                                            ->whereIn('wilker_id', [$event->wilkerId])
                                            ->get();
                                            
            $operasional->each(function($item, $key){

                return $item->delete();

            });

        } else {

            throw new ModelNotFoundException(); 
        }

    }
}
