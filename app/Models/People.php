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
        'user_id', // Ensure this is included in fillable
    ];

    protected $casts = [
        'interests' => 'array', // Cast interests to an array
    ];

    /**
     * Get the user that owns the people.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
