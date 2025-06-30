@extends('layouts.app')

@section('content')
<x-sub-navbar :links="[
    ['route' => 'suppliers.show', 'params' => ['supplier' => $supplier->id], 'name' => 'Configuración Proveedor', 'active' => true],
    ['route' => 'suppliers.showitems','params' => ['supplier' => $supplier->id] , 'name' => 'Productos', 'active' => false]
]" />

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Editar Proveedor</h4>
            <form action="{{route('suppliers.update', ['supplier' => $supplier])}}" class="card p-3 mt-2" method="POST" autocomplete="off" enctype="multipart/form-data">

                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="name">Nombre de la organización</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$supplier->name}}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="promoter_name">Nombre del promotor</label>
                        <input type="text" name="promoter_name" id="promoter_name" class="form-control" value="{{$supplier->promoter_name}}" >
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{$supplier->description}}" >
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="price">Dirección</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{$supplier->address}}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="phone">Número de Telefono</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{$supplier->phone}}" >
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="email">Correo Electronico</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$supplier->email}}" >
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="website">Página Web</label>
                        <input type="text" name="website" id="website" class="form-control" value="{{$supplier->website}}" >
                    </div>
                    <div class="col-md-6 mt-3">
                        <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{$supplier->id}}">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-outline-secondary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12 mt-4">
            <h5>Productos</h5>
            <div class="card p-3">
                <div class="row justify-content-end">
                    <div class="col-md-12">
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
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->category?->name }}</td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#assignModal-{{ $item->id }}">
                                            Asignar
                                        </button>
                                        <div class="modal fade" id="assignModal-{{ $item->id }}" tabindex="-1" aria-labelledby="assignModalLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="assignModalLabel-{{ $item->id }}">Asignar Producto</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{  route('suppliers.assignItem', ['supplier' => $supplier->id]) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="buy_price" class="form-label">Precio de Compra</label>
                                                                <input type="number" step="0.01" name="buy_price" id="buy_price" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="sell_price" class="form-label">Precio de Venta</label>
                                                                <input type="number" step="0.01" name="sell_price" id="sell_price" class="form-control" required>
                                                            </div>
                                                            <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{$supplier->id}}">
                                                            <input type="hidden" name="item_id" id="item_id" class="form-control" value="{{ $item->id }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
<x-delete-alert />

@endsection
