<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // First name
            $table->string('surname')->nullable(); // Surname
            $table->string('south_african_id_number')->nullable(); // South African ID Number
            $table->string('mobile_number', 15)->nullable(); // Mobile Number
            $table->string('email')->unique(); // Email Address
            $table->date('date_of_birth')->nullable(); // Date of Birth
            $table->string('language')->nullable(); // Language preference
            // $table->timestamp('email_verified_at')->nullable();
            $table->json('interests')->nullable(); // Interests (array of strings)
            $table->timestamps(); // Created at and Updated at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
