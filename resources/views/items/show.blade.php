@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Editar Producto</h4>
            <form action="{{route('items.update', ['item' => $item])}}" class="card p-3 mt-2" method="POST" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$item->name}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{$item->description}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="category_id">Categoria</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="price">Precio</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{$item->price}}" required>
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