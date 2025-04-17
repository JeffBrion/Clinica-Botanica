@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Ingresar Proveedor Nuevo</h5>
            <form action="{{ Route('suppliers.store') }}" class="card p-3 mt-2" method="POST">
                @csrf
                <div class="row">

                    <div class="form-group col-md-6 mt-3">
                        <label for="name">Nombre de la organización</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="promoter_name">Nombre del promotor</label>
                        <input type="text" name="promoter_name" id="promoter_name" class="form-control" required>
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
                        <input type="email" name="email" id="email" class="form-control" >
                    </div>       
                    <div class="form-group col-md-6 mt-3">
                        <label for="website">Página Web</label>
                        <input type="text" name="website" id="website" class="form-control" >
                    </div> 
                    <div class="col-md-12 mt-2">
                        <button type="submit" class="btn btn-outline-secondary">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12 mt-4">
            <h5>Proveedores</h5>
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
                                <th>Nombre del promotor</th>
                                <th>Descripción</th>
                                <th>Dirección</th>
                                <th>Número de Telefono</th>
                                <th>Correo Electronico</th>
                                <th>Página Web</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->promoter_name }}</td>
                                    <td>{{ $supplier->description }}</td>
                                    <td>{{ $supplier->address}}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->website }}</td>
                                    <td>
                                        <a href="{{route('suppliers.show', ['supplier' => $supplier])}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                        <button class="delete-button btn btn-danger" data-url="{{route('suppliers.delete', ['supplier' => $supplier])}}"><i class='bx bxs-trash-alt'></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<x-delete-alert />
@endsection