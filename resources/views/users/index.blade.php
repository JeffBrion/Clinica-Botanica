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
                       <div class="mt-4" id="modules">
                        <h6 class="mb-3">Selecciona los Módulos</h6>
                        <div class="row g-3">
                            @foreach($modules as $module)
                                <div class="col-md-4">
                                    <input type="checkbox" class="btn-check" id="module-{{$module->id}}" name="modules[]" value="{{$module->id}}">
                                    <label class="card btn btn-outline-primary text-start h-100" for="module-{{$module->id}}">
                                        <div class="card-body py-3">
                                            <h6 class="card-title mb-0">{{$module->name}}</h6>
                                        </div>
                                    </label>
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
