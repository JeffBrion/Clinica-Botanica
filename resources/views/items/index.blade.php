@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'items.index', 'name' => 'Productos', 'active' => true],
    ['route' => 'categories.index', 'name' => 'Categorias', 'active' => false],
]"/>
<div class="container mt-3">
    <div class="row g-3">
        <!-- Formulario: Nuevo producto -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-package'></i></div>
                        <div>
                            <h5 class="mb-0">Ingresar Producto</h5>
                            <small class="text-muted">Registra un nuevo producto y asígnale su categoría.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ Route('items.store') }}" method="POST">
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
                            <div class="col-md-6 position-relative">
                                <label for="category_search" class="form-label">Buscar Categoría</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-search'></i></span>
                                    <input type="text" id="category_search" class="form-control" placeholder="Buscar categoría...">
                                </div>
                                <ul class="list-group mt-1" id="category_search_results" style="display:none; position:absolute; z-index:1000; width:100%;"></ul>
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Categoria</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="" selected disabled>Seleccione una categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success"><i class='bx bx-plus-medical'></i> Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listado: Productos -->
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden mt-1">
                <div class="items-hero d-flex flex-wrap align-items-center justify-content-between p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-list-ul'></i></div>
                        <div>
                            <h5 class="mb-1">Productos</h5>
                            <div class="text-muted small">Listado de productos registrados.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                            <i class='bx bx-layer me-1'></i> {{ method_exists($items, 'total') ? $items->total() : count($items) }} en total
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
                                    <th>Categoria</th>
                                    <th style="width: 160px;">Código</th>
                                    <th style="width: 140px;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="fw-medium">{{ $item->name }}</td>
                                        <td class="text-truncate" style="max-width: 360px;" title="{{ $item->description }}">{{ $item->description }}</td>
                                        <td>{{ $item->category?->name }}</td>
                                        <td><span class="code-pill">{{ $item->code }}</span></td>
                                        <td>
                                            <a href="{{route('items.show', ['item' => $item])}}" class="btn btn-outline-primary btn-sm" title="Ver"><i class='bx bxs-show'></i> Ver</a>
                                            <button class="delete-button btn btn-outline-danger btn-sm" data-url="{{route('items.delete', ['item' => $item])}}" title="Eliminar"><i class='bx bxs-trash-alt'></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                  <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const searchInput = document.getElementById('category_search');
                            const resultsList = document.getElementById('category_search_results');
                            const select = document.getElementById('category_id');
                            let categories = [
                                @foreach($categories as $category)
                                    {id: {{ $category->id }}, name: "{{ addslashes($category->name) }}"},
                                @endforeach
                            ];

                            searchInput.addEventListener('input', function () {
                                const query = this.value.toLowerCase();
                                resultsList.innerHTML = '';
                                if (query.length === 0) {
                                    resultsList.style.display = 'none';
                                    return;
                                }
                                const filtered = categories.filter(cat => cat.name.toLowerCase().includes(query));
                                if (filtered.length === 0) {
                                    resultsList.style.display = 'none';
                                    return;
                                }
                                filtered.forEach(cat => {
                                    const li = document.createElement('li');
                                    li.className = 'list-group-item list-group-item-action';
                                    li.textContent = cat.name;
                                    li.onclick = function () {
                                        select.value = cat.id;
                                        searchInput.value = cat.name;
                                        resultsList.style.display = 'none';
                                    };
                                    resultsList.appendChild(li);
                                });
                                resultsList.style.display = 'block';
                            });

                            document.addEventListener('click', function (e) {
                                if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
                                    resultsList.style.display = 'none';
                                }
                            });
                        });
                    </script>
<x-delete-alert />
@endsection

                <style>
                .items-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
                .hero-icon{ width: 40px; height: 40px; background:#198754; color:#fff; font-size: 20px; }
                thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
                .code-pill{ display:inline-block; padding: 4px 8px; background:#f1f3f5; border-radius: 6px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
                </style>
