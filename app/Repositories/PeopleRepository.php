<?php 

namespace App\Repositories;

use App\Models\People;

class PeopleRepository
{
    public function allByUser($userId)
    {
        return People::where('user_id', $userId)->get();
    }

    public function create(array $data)
    {
        return People::create($data);
    }

    public function findByIdAndUser($id, $userId)
    {
        return People::where('id', $id)->where('user_id', $userId)->firstOrFail();
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
