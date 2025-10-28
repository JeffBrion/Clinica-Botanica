@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'items.index', 'name' => 'Productos', 'active' => false],
    ['route' => 'categories.index', 'name' => 'Categorias', 'active' => true],
]"/>
<div class="container mt-3">
    <div class="row g-3">
        <!-- Formulario: Nueva categoría -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-purchase-tag'></i></div>
                        <div>
                            <h5 class="mb-0">Ingresar Categoría</h5>
                            <small class="text-muted">Crea una nueva categoría para organizar tus productos.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ Route('categories.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-edit'></i></span>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="description" class="form-label">Descripción</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-align-left'></i></span>
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success"><i class='bx bx-plus-medical'></i> Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listado: Categorías -->
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden mt-1">
                <div class="categories-hero d-flex flex-wrap align-items-center justify-content-between p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-category'></i></div>
                        <div>
                            <h5 class="mb-1">Categorías</h5>
                            <div class="text-muted small">Listado de categorías registradas.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                            <i class='bx bx-layer me-1'></i> {{ method_exists($categories, 'total') ? $categories->total() : count($categories) }} en total
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
                                    <th>Descripción</th>
                                    <th style="width: 140px;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="fw-medium">{{ $category->name }}</td>
                                        <td class="text-truncate" style="max-width: 360px;" title="{{ $category->description }}">{{ $category->description }}</td>
                                        <td>
                                            <a href="{{route('categories.show', ['category' => $category])}}" class="btn btn-outline-primary btn-sm" title="Ver"><i class='bx bxs-show'></i> Ver</a>
                                            <button class="delete-button btn btn-outline-danger btn-sm" data-url="{{route('categories.delete', ['category' => $category])}}" title="Eliminar"><i class='bx bxs-trash-alt'></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div>
                        {{ $category->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<x-delete-alert />

<style>
.categories-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 40px; height: 40px; background:#198754; color:#fff; font-size: 20px; }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
@endsection
