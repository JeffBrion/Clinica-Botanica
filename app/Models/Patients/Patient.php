<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Everth\UserStamps\UserStampsTrait;

class Patient extends Model
{
    use HasFactory, UserStampsTrait;

    protected $fillable = [
        'name',
        'last_name',
        'gender',
        'birth_date',
        'phone',
        'email',
        'address',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}
