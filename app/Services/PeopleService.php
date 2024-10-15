<?php

namespace App\Services;

use App\Repositories\PeopleRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\User;
use App\Models\People; 
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeopleService
{
    protected $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    public function getAllPeople($userId)
    {
        return $this->peopleRepository->allByUser($userId);
    }

    public function createPerson(array $data)
    {
        $person = $this->peopleRepository->create($data);
        try {
            Mail::to($person->email)->send(new User($person->name));
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            // Optionally, you can return a response or handle the failure in a way that fits your application
            return response()->json(['message' => 'Person created, but failed to send email notification.'], 201);
        }
        return $person;
    }

    public function getPerson($id, $userId)
    {
        $person = $this->peopleRepository->findByIdAndUser($id, $userId);

        if (!$person) {
            throw new ModelNotFoundException("Person not found.");
        }

        return $person;
    }

    public function updatePerson($id, array $data, $userId)
    {
        $person = $this->getPerson($id, $userId);
        $person->update($data);
        return $person; // Return the updated person object
    }

    public function deletePerson($id, $userId)
    {
        $person = $this->getPerson($id, $userId);
        $this->peopleRepository->delete($person);
        return ['message' => 'Person deleted successfully.'];
    }
}
