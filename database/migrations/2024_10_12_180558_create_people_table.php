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
            $table->string('surname'); // Surname
            $table->string('south_african_id_number')->unique(); // South African ID Number
            $table->string('mobile_number')->unique(); // Mobile Number
            $table->string('email')->unique(); // Email Address
            $table->date('date_of_birth'); // Date of Birth
            $table->string('language'); // Language preference
            $table->json('interests')->nullable(); // Interests (multiple values stored as JSON)
            $table->timestamps(); // Created at and Updated at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
