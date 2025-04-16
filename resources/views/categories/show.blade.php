@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Editar Categoria</h4>
            <form action="{{route('categories.update', ['category' => $category])}}" class="card p-3 mt-2" method="POST" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{$category->description}}" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-outline-secondary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<x-delete-alert />

@endsection