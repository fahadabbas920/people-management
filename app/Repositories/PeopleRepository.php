<?php 

namespace App\Repositories;

use App\Models\People;

class PeopleRepository
{
    public function all()
    {
        return People::all();
    }

    public function create(array $data)
    {
        return People::create($data);
    }

    public function find($id)
    {
        return People::findOrFail($id);
    }

    public function update(People $person, array $data)
    {
        return $person->update($data);
    }

    public function delete(People $person)
    {
        return $person->delete();
    }
}
