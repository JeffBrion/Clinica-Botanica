@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => true],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => false],        
]"/>

<div class="container">
    <div class="row">
        <div class="col-lg-12 mt-4">
            <h5>Prodcutos</h5>
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
                                <th>Cantidad</th>
                                <th>Precio de compra</th>
                                <th>Precio de venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->supplierProduct->item->name }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->supplierProduct->buy_price }}</td>
                                    <td>{{ $inventory->supplierProduct->sell_price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection