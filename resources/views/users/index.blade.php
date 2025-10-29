@extends('layouts.app')

@section('content')
    <div class="container">
        <style>
            /* Alineado al estilo de Items */
            .users-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
            .hero-icon{ width: 40px; height: 40px; background:#198754; color:#fff; font-size: 20px; }
            thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
        </style>

        <!-- Formulario: Crear usuario (estilo Items) -->
        <div class="card border-0 shadow-sm mt-4 mb-3">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bxs-user-detail'></i></div>
                    <div>
                        <h5 class="mb-0">Crear usuario</h5>
                        <small class="text-muted">Completa los datos y asigna módulos según el rol.</small>
                    </div>
                </div>
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

        <div class="card border-0 shadow-sm overflow-hidden mt-1">
            <div class="users-hero d-flex flex-wrap align-items-center justify-content-between p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-list-ul'></i></div>
                    <div>
                        <h5 class="mb-1">Usuarios</h5>
                        <div class="text-muted small">Listado de usuarios registrados.</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                        <i class='bx bx-layer me-1'></i> {{ method_exists($users, 'total') ? $users->total() : count($users) }} en total
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-2">
                    <div class="col-12">
                        <x-search-bar :table="'users_table'"/>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover m-0" id="users_table">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th style="width: 160px;" class="text-end">Opciones</th>
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
                                        <a href="{{route('users.show', ['user' => $user])}}" class="btn btn-outline-primary btn-sm" title="Ver"><i class='bx bxs-show'></i> Ver</a>
                                        <button class="delete-button btn btn-outline-danger btn-sm" data-url="{{route('users.delete', ['user' => $user])}}" title="Eliminar"><i class='bx bxs-trash-alt'></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <x-delete-alert />
    </div>
@endsection

@section('scripts')
    <script src="/js/users/index.js"></script>
@endsection
