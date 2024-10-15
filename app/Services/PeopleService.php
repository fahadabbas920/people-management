<?php
namespace App\Services;

use App\Repositories\PeopleRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\User;

class PeopleService
{
    protected $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    public function getAllPeople()
    {
        return $this->peopleRepository->all();
    }

    public function createPerson(array $data)
    {
        $person = $this->peopleRepository->create($data);
        Mail::to($person->email)->send(new User($person->name));
        return $person;
    }

    public function getPerson($id)
    {
        return $this->peopleRepository->find($id);
    }

    public function updatePerson($id, array $data)
    {
        $person = $this->peopleRepository->find($id);
        return $this->peopleRepository->update($person, $data);
    }

    public function deletePerson($id)
    {
        $person = $this->peopleRepository->find($id);
        return $this->peopleRepository->delete($person);
    }
}
