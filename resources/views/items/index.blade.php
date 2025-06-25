@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'items.index', 'name' => 'Productos', 'active' => true],
    ['route' => 'categories.index', 'name' => 'Categorias', 'active' => false],
]"/>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Ingresar Producto Nuevo</h5>
            <form action="{{ Route('items.store') }}" class="card p-3 mt-2" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 mt-3">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mt-3 position-relative">
                        <label for="category_search">Buscar Categoría</label>
                        <input type="text" id="category_search" class="form-control" placeholder="Buscar categoría...">
                        <ul class="list-group mt-1" id="category_search_results" style="display:none; position:absolute; z-index:1000; width:100%;"></ul>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="category_id">Categoria</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="" selected disabled>Seleccione una categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-12 mt-2">
                        <button type="submit" class="btn btn-outline-secondary">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12 mt-4">
            <h5>Productos</h5>
            <div class="card p-3">
                <div class="row justify-content-end">
                    <div class="col-md-8">
                        <x-search-bar :table="'users_table'"/>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-0" id="users_table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Categoria</th>
                                <th>Código</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->category?->name }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>
                                        <a href="{{route('items.show', ['item' => $item])}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                        <button class="delete-button btn btn-danger" data-url="{{route('items.delete', ['item' => $item])}}"><i class='bx bxs-trash-alt'></i></button>
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
