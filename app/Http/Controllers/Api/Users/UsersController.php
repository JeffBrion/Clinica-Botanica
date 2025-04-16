<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function search($text)
    {
        $users = User::select('id', 'name')->where('name', 'like', "%$text%")->get();

        if($users->isEmpty()){
            return response()->json([
                'message' => 'No se encontraron usuarios',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Usuarios encontrados',
            'data' => $users
        ], 200);
    }
}
