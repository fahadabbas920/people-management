<?php

namespace App\Http\Controllers;

use App\Models\People; // Adjust this if your model name is different
use Inertia\Inertia;

class PeopleController extends Controller
{
    public function index()
    {
        // Retrieve all people from the database
        $people = People::all(); // Use appropriate model

        // Return the Inertia view with the people data
        return Inertia::render('People', [
            'people' => $people,
        ]);
    }
}
