<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\People; // Ensure this is correct
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    public function run()
    {
        // Insert sample data
        DB::table('people')->insert([
            [
                'name' => 'John',
                'surname' => 'Doe',
                'south_african_id_number' => '8001015009087',
                'mobile_number' => '0811234567',
                'email' => 'john.doe@example.com',
                'date_of_birth' => '1980-01-01',
                'language' => 'English',
                'interests' => json_encode(['Reading', 'Cycling']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane',
                'surname' => 'Smith',
                'south_african_id_number' => '9002026009088',
                'mobile_number' => '0829876543',
                'email' => 'jane.smith@example.com',
                'date_of_birth' => '1990-02-02',
                'language' => 'Afrikaans',
                'interests' => json_encode(['Cooking', 'Hiking']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
