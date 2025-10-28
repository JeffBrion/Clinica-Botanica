@extends('layouts.app')

@section('content')
    <div class="container">
        <style>
            .hero-users { background: linear-gradient(135deg, #22c55e 0%, #4f46e5 100%); color: #fff; }
            .table-sticky thead th { position: sticky; top: 0; z-index: 2; background: #f8fafc; }
        </style>

        <div class="card border-0 shadow rounded-4 overflow-hidden mt-4">
            <div class="hero-users p-4 p-md-5 d-flex align-items-center justify-content-between">
                <div class="me-4">
                    <span class="badge rounded-pill bg-white text-dark mb-2" style="opacity:.9">Usuarios</span>
                    <h2 class="h4 mb-2">Crear usuario</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,.9)">Completa los datos y asigna módulos según el rol.</p>
                </div>
                <div class="d-none d-md-block"><i class='bx bxs-user-detail' style="font-size:64px; opacity:.9"></i></div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" class="row g-3" method="POST" autocomplete="off">
                    @csrf
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-lock'></i></span>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Rol</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                            <select name="role" id="role" class="form-select" required>
                                <option value="Usuario">Usuario</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mt-2" id="modules">
                        <h6 class="mb-3">Selecciona los Módulos</h6>
                        <div class="row g-3">
                            @foreach($modules as $module)
                                <div class="col-md-4">
                                    <input type="checkbox" class="btn-check checkbox-modules" id="module-{{$module->id}}" name="modules[]" value="{{$module->id}}">
                                    <label class="card btn btn-outline-primary text-start h-100" for="module-{{$module->id}}">
                                        <div class="card-body py-3">
                                            <h6 class="card-title mb-0">{{$module->name}}</h6>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class='bx bx-user-plus me-1'></i> Agregar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow rounded-4 mt-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <div style="min-width: 260px" class="me-3">
                    <x-search-bar :table="'users_table'"/>
                </div>
                <h5 class="mb-0">Usuarios</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive table-sticky">
                    <table class="table table-hover align-middle mb-0" id="users_table">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th class="text-end">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if($user->role === 'Administrador')
                                            <span class="badge bg-primary-subtle text-primary" style="border:1px solid rgba(59,130,246,.25)">Administrador</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success" style="border:1px solid rgba(16,185,129,.25)">Usuario</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{route('users.show', ['user' => $user])}}" class="btn btn-sm btn-outline-primary"><i class='bx bxs-show me-1'></i> Ver</a>
                                        <button class="delete-button btn btn-sm btn-outline-danger" data-url="{{route('users.delete', ['user' => $user])}}"><i class='bx bxs-trash-alt me-1'></i> Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $users->links() }}
            </div>
        </div>

        <x-delete-alert />
    </div>
@endsection

@section('scripts')
    <script src="/js/users/index.js"></script>
@endsection
