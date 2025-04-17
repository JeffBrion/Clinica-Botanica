@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Editar Proveedor</h4>
            <form action="{{route('suppliers.update', ['supplier' => $supplier])}}" class="card p-3 mt-2" method="POST" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="name">Nombre de la organización</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$supplier->name}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="promoter_name">Nombre del promotor</label>
                        <input type="text" name="promoter_name" id="promoter_name" class="form-control" value="{{$supplier->name}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{$supplier->description}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="price">Dirección</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{$supplier->address}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="phone">Número de Telefono</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{$supplier->phone}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="email">Correo Electronico</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$supplier->email}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="website">Página Web</label>
                        <input type="text" name="website" id="website" class="form-control" value="{{$supplier->website}}" required>
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