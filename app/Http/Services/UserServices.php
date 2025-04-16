<?php
namespace App\Http\Services;

use App\Models\User;
use App\Models\Users\Module;
use Illuminate\Support\Facades\Auth;

class UserServices
{
    public static function makeUser($request)
    {
        if($request->role === 'Usuario')
        {
            $user = User::create([
                'name' => $request['name'],
                'password' => bcrypt($request['password']),
                'role' => $request['role'],
            ]);

            if($request->modules === null)
            {
                return $user;
            }

            foreach($request->modules as $module)
            {
                $user->userModule()->create([
                    'module_id' => $module,
                ]);
            }

            return $user;
        }

        else if($request->role === 'Trabajador')
        {

            $user = User::create([
                'name' => $request['name'],
                'password' => bcrypt($request['password']),
                'role' => $request['role'],
            ]);

            $module = Module::where('internal_name', 'evaluations')->first();
            if ($module)
            {
                $user->userModule()->create([
                    'module_id' => $module->id,
                ]);
            }
            return $user;
        }

        else if($request->role === 'Administrador')
        {
            $user = User::create([
                'name' => $request['name'],
                'password' => bcrypt($request['password']),
                'role' => $request['role'],
            ]);

            return $user;
        }

        return null;
    }

    public static function updateUser($request, User $user)
    {
        $user->fill($request->except('password'));
        if($request->password !== null)
        {
            $user->password = bcrypt($request['password']);
        }

        if($user->save())
        {
            return $user;
        }

        return null;
    }

    public static function addModules($request, User $user)
    {
        foreach($request->modules as $module)
        {
            if($user->userModule()->where('module_id', $module)->count() === 0)
            {
                $user->userModule()->create([
                    'module_id' => $module,
                ]);
            }
        }

        return $user;
    }

    public static function updatePassword($request)
    {
        if ($request['password'] !== $request['password_confirmation']) {
            return null;
        }

        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $user->password = bcrypt($request['password']);

        if ($user->save()) {
            return $user;
        }

        return null;
    }
}
