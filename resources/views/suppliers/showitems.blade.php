@extends('layouts.app')

@section('content')
<x-sub-navbar :links="[
    ['route' => 'suppliers.show', 'params' => ['supplier' => $supplier->id], 'name' => 'Configuración Proveedor', 'active' => false],
    ['route' => 'suppliers.showitems','params' => ['supplier' => $supplier->id] , 'name' => 'Productos', 'active' => true]
]" />
<div class="container">
    <div class="card p-3 mt-2">
        <h4>Productos Asignados a Proveedor</h4>
        @if($items->isEmpty())
            <div class="alert alert-info">
                No hay items asignados a este proveedor.
            </div>
        @else
        <div class="row justify-content-end">
                    <div class="col-md-12">
                        <x-search-bar :table="'users_table'"/>
                    </div>
                </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Producto</th>
                        <th>Precio de Compra</th>
                        <th>Precio de Venta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->supplier?->name }}</td>
                            <td>{{ $item->item?->name }}</td>
                            <td>{{ $item->buy_price }}</td>
                            <td>{{ $item->sell_price }}</td>
                            <td><button class="delete-button btn btn-danger btn-sm" data-url="{{ route('suppliers.deleteItem', ['item' => $item]) }}">Eliminar</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="mt-2">
            {{ $items->links() }}
        </div>
    </div>
</div>
<x-delete-alert />
@endsection
