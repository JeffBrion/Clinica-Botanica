@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        .hero-user { background: linear-gradient(135deg, #22c55e 0%, #4f46e5 100%); color:#fff; }
        .table-sticky thead th { position: sticky; top: 0; z-index: 2; background: #f8fafc; }
    </style>

    <div class="card border-0 shadow rounded-4 overflow-hidden mt-4">
        <div class="hero-user p-4 p-md-5 d-flex align-items-center justify-content-between">
            <div class="me-4">
                <span class="badge rounded-pill bg-white text-dark mb-2" style="opacity:.9">Usuario</span>
                <h2 class="h4 mb-1">{{ $user->name }}</h2>
                @if(!empty($user->role))
                    <span class="badge bg-primary-subtle text-primary" style="border:1px solid rgba(59,130,246,.25)">{{ $user->role }}</span>
                @endif
            </div>
            <div class="d-none d-md-block"><i class='bx bxs-user' style="font-size:64px; opacity:.9"></i></div>
        </div>
        <div class="card-body">
            <form action="{{route('users.update', ['user' => $user])}}" class="row g-3" method="POST" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                        <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-lock'></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="(opcional)">
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addModuleModal"><i class='bx bx-grid-add me-1'></i> Agregar módulos</button>
                    <button type="submit" class="btn btn-success"><i class='bx bx-save me-1'></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow rounded-4 mt-4">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Módulos asignados</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive table-sticky">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th class="text-end">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->userModule as $userModule)
                            <tr>
                                <td>{{ $userModule->module->name }}</td>
                                <td class="text-end">
                                    @php $routeName = $userModule->module->access_route_name; @endphp
                                    <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}" class="btn btn-sm btn-outline-primary" @if(!Route::has($routeName)) tabindex="-1" aria-disabled="true" @endif><i class='bx bxs-show me-1'></i> Ir</a>
                                    <button class="delete-button btn btn-sm btn-outline-danger" data-url="{{route('users.deleteModule', ['userModule' => $userModule ,'user' => $user])}}"><i class='bx bxs-trash-alt me-1'></i> Quitar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">Sin módulos asignados.</td>
                            </tr>
                        @endforelse
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
                    <h5 class="modal-title" id="addModuleModalLabel">Agregar módulos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modules">
                        <div class="row g-3 user-select-none">
                            @foreach($modules as $module)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <label for="module-{{$module->id}}" class="form-check-label d-flex align-items-center gap-2">
                                            <input type="checkbox" name="modules[]" id="module-{{$module->id}}" value="{{$module->id}}" class="form-check-input checkbox-modules">
                                            <small class="ms-1">{{$module->name}}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
