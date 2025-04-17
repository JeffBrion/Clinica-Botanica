<?php

namespace App\Models\Suppliers;

use Illuminate\Database\Eloquent\Model;
use Everth\UserStamps\UserStampsTrait;

class Supplier extends Model
{
    use UserStampsTrait;

    protected $fillable = [
        'name',
        'promoter_name',
        'description',
        'address',
        'phone',
        'email',
        'website',
    ];

}
