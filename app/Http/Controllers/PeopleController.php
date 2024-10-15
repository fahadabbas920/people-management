<?php

namespace App\Http\Controllers;

use App\Services\PeopleService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PeopleController extends Controller
{
    protected $peopleService;

    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    protected function validationRules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'south_african_id_number' => 'required|string|max:13|unique:people,south_african_id_number' . ($id ? ',' . $id : ''),
            'mobile_number' => 'required|string|max:15|unique:people,mobile_number' . ($id ? ',' . $id : ''),
            'email' => 'required|email|max:255|unique:people,email' . ($id ? ',' . $id : ''),
            'date_of_birth' => 'required|date',
            'language' => 'required|string|max:50',
            'interests' => 'required|array',
        ];
    }

    public function index()
    {
        try {
            return response()->json($this->peopleService->getAllPeople(), 200);
        } catch (Exception $e) {
            Log::error('Error retrieving people: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to retrieve people.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate($this->validationRules());
            $validatedData['user_id'] = auth()->id();

            return response()->json($this->peopleService->createPerson($validatedData), 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Database error on store: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to save person data.'], 500);
        } catch (Exception $e) {
            Log::error('Unexpected error while creating person: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->peopleService->getPerson($id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Person not found.'], 404);
        } catch (Exception $e) {
            Log::error('Error retrieving person: ' . $e->getMessage());
            return response()->json(['message' => 'Error retrieving person.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->validationRules($id));
            return response()->json($this->peopleService->updatePerson($id, $validatedData), 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Database error on update: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to update person data.'], 500);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Person not found.'], 404);
        } catch (Exception $e) {
            Log::error('Unexpected error while updating person: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->peopleService->deletePerson($id);
            return response()->json(['message' => 'Person deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Person not found.'], 404);
        } catch (Exception $e) {
            Log::error('Error deleting person: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting person.'], 500);
        }
    }
}
