@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'items.index', 'name' => 'Productos', 'active' => false],
    ['route' => 'categories.index', 'name' => 'Categorias', 'active' => true],        
]"/>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Ingresar Categoria Nuevo</h5>
            <form action="{{ Route('categories.store') }}" class="card p-3 mt-2" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 mt-3">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="name">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" required>
                    </div>   
                    <div class="col-md-12 mt-2">
                        <button type="submit" class="btn btn-outline-secondary">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12 mt-4">
            <h5>Categorias</h5>
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
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a href="{{route('categories.show', ['category' => $category])}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                        <button class="delete-button btn btn-danger" data-url="{{route('categories.delete', ['category' => $category])}}"><i class='bx bxs-trash-alt'></i></button>
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
<x-delete-alert />
@endsection