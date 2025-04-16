@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Editar Usuario</h4>
            <form action="{{route('users.update', ['user' => $user])}}" class="card p-3 mt-2" method="POST" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-outline-secondary">Actualizar</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">Agregar Modulos</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <h4>Modulos</h4>
            <div class="card p-3">
                <table class="table table-striped table-hover m-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->userModule as $userModule)
                            <tr>
                                <td>{{ $userModule->module->name }}</td>
                                <td>
                                    <a href="{{ Route::has($userModule->module->access_route_name) ? route($userModule->module->access_route_name) : ''}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                    <button class="delete-button btn btn-danger" data-url="{{route('users.deleteModule', ['userModule' => $userModule ,'user' => $user])}}"><i class='bx bxs-trash-alt'></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<x-delete-alert />

<!-- modal add module -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('users.addModules', ['user' => $user])}}" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="mt-3 col-md-12 mt-3" id="modules">
                        <h4>Módulos</h4>
                        <div class="row user-select-none mt-2">
                            @foreach($modules as $module)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <label for="module-{{$module->id}}" class="form-check-label d-flex">
                                            <input type="checkbox" name="modules[]" id="module-{{$module->id}}" value="{{$module->id}}" class="form-check checkbox-modules">
                                            <small>{{$module->name}}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection