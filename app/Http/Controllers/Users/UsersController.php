<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Services\UserServices;
use App\Models\Users\Module;
use App\Models\Users\UserModule;

class UsersController extends Controller
{
    public function index($pagination = 20)
    {
        $users = User::orderBy('created_at', 'desc')->paginate($pagination);
        $modules = Module::select('id', 'name', 'icon')->get();

        return view('users.index', compact('users', 'modules'));
    }

    public function showChangePassword()
    {
        return view('users.changepassword');
    }

    public function show(User $user)
    {
        $modules = Module::select('id', 'name', 'icon')->get();

        return view('users.show', compact('user', 'modules'));
    }

    public function store(UsersStoreRequest $request)
    {
        $request->validated();

        $response = UserServices::makeUser($request);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al crear el usuario',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Usuario creado correctamente',
            'type' => 'success',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'password' => 'required|confirmed',
            ],
            [
                'password.required' => 'El campo contraseña es obligatorio',
                'password.confirmed' => 'Las contraseñas no coinciden',
            ]
        );

        $response = UserServices::updatePassword($request);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al actualizar la contraseña',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Contraseña actualizada correctamente',
            'type' => 'success',
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'El campo nombre es obligatorio',
        ]);

        $response = UserServices::updateUser($request, $user);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al actualizar el usuario',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Usuario actualizado correctamente',
            'type' => 'success',
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with([
            'message' => 'Usuario eliminado correctamente',
            'type' => 'success',
        ]);
    }

    public function deleteModule(UserModule $userModule, User $user)
    {
        $userModule->delete();

        return redirect()->route('users.show', $user)->with([
            'message' => 'Módulo eliminado correctamente',
            'type' => 'success',
        ]);
    }

    public function addModules(Request $request, User $user)
    {
        $request->validate([
            'modules' => 'required',
        ], [
            'modules.required' => 'Debes seleccionar al menos un módulo',
        ]);

        $response = UserServices::addModules($request, $user);

        if($response === null)
        {
            return redirect()->route('users.show', $user)->with([
                'message' => 'Error al agregar los módulos',
                'type' => 'danger',
            ]);
        }

        return redirect()->route('users.show', $user)->with([
            'message' => 'Módulos agregados correctamente',
            'type' => 'success',
        ]);
    }
}
