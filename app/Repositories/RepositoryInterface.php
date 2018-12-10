<?php 

namespace App\Repositories;

interface RepositoryInterface
{
	public function all();

    public function show($id);
    
    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
}