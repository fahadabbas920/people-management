<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\User;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Validation\ValidationException;

class PeopleController extends Controller
{
    // Retrieve all people from the database
    public function index()
    {
        try {
            $people = People::all();
            return response()->json($people, 200); // 200 OK
        } catch (Exception $e) {
            Log::error('Error retrieving people: ' . $e->getMessage());
            return response()->json(['message' => 'Error retrieving people'], 500);
        }
    }

    // Store a new person in the database
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'south_african_id_number' => 'required|string|max:13|unique:people,south_african_id_number',
                'mobile_number' => 'required|string|max:15|unique:people,mobile_number',
                'email' => 'required|email|max:255|unique:people,email',
                'date_of_birth' => 'required|date',
                'language' => 'required|string|max:50',
                'interests' => 'required|array',
            ]);

            $person = People::create($validatedData);

            // Send an email after person creation
            Mail::to($person->email)->send(new User($person->name));

            return response()->json($person, 201); // 201 Created
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            // Handle database errors, such as duplicate entries
            Log::error('Database error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error saving the person data. Please try again later.'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error creating person: ' . $e->getMessage());
            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    // Retrieve a single person by ID
    public function show($id)
    {
        try {
            $person = People::findOrFail($id);
            return response()->json($person, 200); // 200 OK
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Person not found'
            ], 404);
        } catch (Exception $e) {
            Log::error('Error retrieving person: ' . $e->getMessage());
            return response()->json(['message' => 'Error retrieving person'], 500);
        }
    }

    // Update an existing person
    public function update(Request $request, $id)
    {
        // Log the request for debugging purposes
        Log::info('Updating person with ID: ' . $id);
        Log::info('Request data: ', $request->all());

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'south_african_id_number' => 'required|string|max:13|unique:people,south_african_id_number,' . $id,
                'mobile_number' => 'required|string|max:15|unique:people,mobile_number,' . $id,
                'email' => 'required|email|max:255|unique:people,email,' . $id,
                'date_of_birth' => 'required|date',
                'language' => 'required|string|max:50',
                'interests' => 'required|array',
            ]);

            // Find the person by ID and update
            $person = People::find($id);

            if (!$person) {
                Log::error('Person not found with ID: ' . $id);
                return response()->json(['message' => 'Person not found'], 404);
            }

            $person->update($validatedData);

            Log::info('Person updated successfully: ', [$person]);

            return response()->json($person, 200); // 200 OK

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error updating person data. Please try again later.'
            ], 500);
        } catch (Exception $e) {
            Log::error('Error updating person: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    // Delete a person from the database
    public function destroy($id)
    {
        try {
            $person = People::find($id);

            if (!$person) {
                return response()->json(['message' => 'Person not found'], 404);
            }

            $person->delete();

            return response()->json(['message' => 'Person deleted successfully'], 200); // 200 OK
        } catch (Exception $e) {
            Log::error('Error deleting person: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting person'], 500);
        }
    }
}
