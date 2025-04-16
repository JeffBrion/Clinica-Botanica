@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5>Ingresar Usuario Nuevo</h5>
                <form action="{{ route('users.store') }}" class="card p-3 mt-2" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mt-3">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6 mt-3">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6 mt-3">
                            <label for="Rol">Rol</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="Usuario">Usuario</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                        <div class="mt-3 d-none col-md-12 mt-3" id="modules">
                            <h6>Módulos</h6>
                            <div class="row user-select-none">
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
                        
                        <div class="col-md-12 mt-2">
                            <button type="submit" class="btn btn-outline-secondary">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 mt-4">
                <h5>Usuarios</h5>
                <div class="card p-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0" id="users_table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <a href="{{route('users.show', ['user' => $user])}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                            <button class="delete-button btn btn-danger" data-url="{{route('users.delete', ['user' => $user])}}"><i class='bx bxs-trash-alt'></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-delete-alert />
@endsection

@section('scripts')
    <script src="/js/users/index.js"></script>
@endsection