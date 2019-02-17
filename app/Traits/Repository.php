<?php 

namespace App\Traits;

trait Repository
{ 
    /*Get all instances of model*/
    public function all()
    {
        return $this->model->all();
    }

    /*create a new record in the database*/
    public function create($data)
    {
        return $this->model->create($data);
    }

    /*update record in the database*/
    public function update($data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    /*remove record from the database*/
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /*show the record with the given id*/
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /*Get the associated model*/
    public function getModel()
    {
        return $this;
    }

    /*Set the associated model*/
    public function setModel($model)
    {
        $this->model = $model;
    }

    /*Eager load database relationships*/
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}