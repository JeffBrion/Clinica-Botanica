@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => false],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => false],
    ['route' => 'inventories.history', 'name' => 'Historial', 'active' => true],
]"/>
<div class="container">
        <div class="row">
        <div class="col-lg-12 mt-4">
            <h5>Historial de Productos</h5>
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
                               <th>Nombre del Producto</th>
                                <th>Cantidad</th>
                                <th>Proveedor</th>
                                <th>Fecha de Ingreso/Salida</th>
                                <th>Observación</th>
                                <th>Usuario</th>
                                 <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                                  @foreach($inventories as $entry)
                                  @if ($entry->status == 'Entrada')
                                    <tr class="table-success">
                                    <td>{{ $entry->supplierProduct->item->name}}</td>
                                    <td>{{ $entry->quantity }}</td>
                                    <td>{{ $entry->supplierProduct->supplier->name }}</td>
                                    <td>{{ $entry->requested_date }}</td>
                                    <td>{{ $entry->observation }}</td>
                                    <td>{{ $entry->createdBy?->name }}</td>
                                    <td>{{ $entry->status }}</td>
                                </tr>
                                  @elseif ($entry->status == 'Eliminado')
                                    <tr class="table-danger">
                                      <td>{{ $entry->supplierProduct->item->name}}</td>
                                      <td>{{ $entry->quantity }}</td>
                                      <td>{{ $entry->supplierProduct->supplier->name }}</td>
                                      <td>{{ $entry->requested_date }}</td>
                                        <td>{{ $entry->observation }}</td>
                                        <td>{{ $entry->createdBy?->name }}</td>
                                      <td>{{ $entry->status }}</td>
                                    </tr>
                                  @else

                                  @endif
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
