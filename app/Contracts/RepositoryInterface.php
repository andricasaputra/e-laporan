<?php 

namespace App\Contracts;

interface RepositoryInterface
{
	public function all();

    public function show($id);
    
    public function create($data);

    public function update($data, $id);

    public function delete($id);
}