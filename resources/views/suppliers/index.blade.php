@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Ingresar Proveedor Nuevo</h5>
            <form action="{{ Route('suppliers.store') }}" class="card p-3 mt-2" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-md-6 mt-3">
                        <label for="name">Nombre de la organización</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="promoter_name">Nombre del promotor</label>
                        <input type="text" name="promoter_name" id="promoter_name" class="form-control" >
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" >
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="address">Dirección</label>
                        <input type="address" name="address" id="address" class="form-control" >
                    </div> 
                    <div class="form-group col-md-6 mt-3">
                        <label for="phone">Número de Telefono</label>
                        <input type="text" name="phone" id="phone" class="form-control" >
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="email">Correo Electronico</label>
                        <input type="text" name="email" id="email" class="form-control" >
                    </div>       
                    <div class="form-group col-md-6 mt-3">
                        <label for="website">Página Web</label>
                        <input type="text" name="website" id="website" class="form-control" >
                    </div> 
                    <div class="form-group col-md-6 mt-3">
                        <label for="image">Imagen</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-12 mt-2">
                        <button type="submit" class="btn btn-outline-secondary">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12 mt-4">
            <h5>Proveedores</h5>
                <div class="row mt-2 d-flex justify-content-between"> 
                    @foreach($suppliers as $supplier)
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card" style="width: 100%;">
                            <img class="card-img-top img-fluid" src="{{ asset('storage/' . $supplier->image_path) }}" alt="{{ $supplier->name }}" alt="Card image cap" style="object-fit: cover; height: 200px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center">{{ $supplier->name }}</h5>
                                <p class="card-text"><strong>Promotor:</strong> {{ $supplier->promoter_name }}</p>
                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="{{ route('suppliers.show', ['supplier' => $supplier]) }}" class="btn btn-primary btn-sm">Ver</a>
                                    <button class="delete-button btn btn-danger btn-sm" data-url="{{ route('suppliers.delete', ['supplier' => $supplier]) }}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                <div class="mt-2">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<x-delete-alert />
@endsection