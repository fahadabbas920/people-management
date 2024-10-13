<?php

namespace App\Http\Controllers;

use App\Models\People; // Adjust this if your model name is different
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PeopleController extends Controller
{
    // Retrieve all people from the database
    public function index()
    {
        $people = People::all();
        return response()->json($people);
    }

    // Store a new person in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'south_african_id_number' => 'required|string|max:13',
            'mobile_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'date_of_birth' => 'required|date',
            'language' => 'required|string|max:50',
            'interests' => 'required|array',
        ]);

        $person = People::create($validatedData);
        return response()->json($person, 201); // 201 Created
    }

    // Retrieve a single person by ID
    public function show($id)
    {
        $person = People::findOrFail($id);
        return response()->json($person);
    }

    // Update an existing person
    // Update an existing person
    public function update(Request $request, $id)
    {
        // Log the request for debugging purposes
        Log::info('Updating person with ID: ' . $id);
        Log::info('Request data: ', $request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'south_african_id_number' => 'required|string|unique:people,south_african_id_number,' . $id,
            'mobile_number' => 'required|string|unique:people,mobile_number,' . $id,
            'email' => 'required|email|unique:people,email,' . $id,
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

        $updated = $person->update($validatedData);

        // Log if the update was successful
        Log::info('Update successful: ', [$updated]);

        return response()->json($person);
    }

    // Delete a person from the database
    public function destroy($id)
    {
        $person = People::find($id);

        if (!$person) {
            return response()->json(['message' => 'Person not found'], 404);
        }

        $person->delete();

        return response()->json(['message' => 'Person deleted successfully']);
    }
}
