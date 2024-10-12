<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'south_african_id_number',
        'mobile_number',
        'email',
        'date_of_birth',
        'language',
        'interests',
    ];
}
