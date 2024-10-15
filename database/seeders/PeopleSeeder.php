<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
            [
                'name' => 'Alice',
                'surname' => 'Johnson',
                'south_african_id_number' => '8503037009089',
                'mobile_number' => '0834567890',
                'email' => 'alice.johnson@example.com',
                'date_of_birth' => '1985-03-03',
                'language' => 'English',
                'interests' => json_encode(['Traveling', 'Photography']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob',
                'surname' => 'Brown',
                'south_african_id_number' => '7504048009090',
                'mobile_number' => '0845678901',
                'email' => 'bob.brown@example.com',
                'date_of_birth' => '1975-04-04',
                'language' => 'Zulu',
                'interests' => json_encode(['Football', 'Gaming']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Charlie',
                'surname' => 'Davis',
                'south_african_id_number' => '6405059009091',
                'mobile_number' => '0856789012',
                'email' => 'charlie.davis@example.com',
                'date_of_birth' => '1995-05-05',
                'language' => 'Xhosa',
                'interests' => json_encode(['Music', 'Art']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

