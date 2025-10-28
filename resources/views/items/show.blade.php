@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
            <div class="d-flex align-items-center gap-2">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-package'></i></div>
                <div>
                    <h5 class="mb-0">Editar Producto</h5>
                    <small class="text-muted">Actualiza los datos del producto seleccionado.</small>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('items.update', ['item' => $item])}}" method="POST" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class='bx bx-edit'></i></span>
                            <input type="text" name="name" id="name" class="form-control" value="{{$item->name}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class='bx bx-align-left'></i></span>
                            <input type="text" name="description" id="description" class="form-control" value="{{$item->description}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Categoria</label>
                        <select name="category_id" id="category_id" class="form-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="code" class="form-label">Código</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class='bx bx-barcode'></i></span>
                            <input type="text" name="code" id="code" class="form-control" value="{{$item->code}}" required readonly>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success"><i class='bx bx-save'></i> Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<x-delete-alert />

<style>
.hero-icon{ width: 40px; height: 40px; background:#198754; color:#fff; font-size: 20px; }
</style>

@endsection
