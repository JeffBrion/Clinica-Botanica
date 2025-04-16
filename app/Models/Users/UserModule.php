<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Everth\UserStamps\UserStampsTrait;
use App\Models\User;

class UserModule extends Model
{
    use HasFactory;
    use UserStampsTrait;

    protected $table = 'users_modules';

    protected $fillable = [
        'user_id',
        'module_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
