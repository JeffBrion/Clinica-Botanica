@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => true],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => false],
    ['route' => 'inventories.history', 'name' => 'Historial', 'active' => false],
]"/>

<div class="container">
    <div class="row">
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
                                <th>Cantidad</th>
                                <th>Proveedor</th>
                                <th>Precio de compra</th>
                                <th>Precio de venta</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inventory)
                            @if ($inventory->status == 'Entrada')
                                                        <tr>
                                    <td>{{ $inventory->supplierProduct->item->name }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->supplierProduct->supplier->name }}</td>
                                    <td>{{ $inventory->supplierProduct->buy_price }}</td>
                                    <td>{{ $inventory->supplierProduct->sell_price }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inventory->id }}">
                                            <i class='bx bx-trash'></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $inventory->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $inventory->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('inventories.history.delete', $inventory->id) }}">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel-{{ $inventory->id }}">Eliminar cantidad de producto</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                                            <div class="mb-3">
                                                                <label for="quantity-{{ $inventory->id }}" class="form-label">Cantidad a eliminar</label>
                                                                <input type="number" class="form-control" id="quantity-{{ $inventory->id }}" name="quantity" min="1" max="{{ $inventory->quantity }}" required>
                                                            </div>
                                                            <div class="mb-3 p-2 rounded bg-light">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-4 mb-2 mb-md-0">
                                                                        <span class="text-muted small">Producto</span><br>
                                                                        <strong>{{ $inventory->supplierProduct->item->name }}</strong>
                                                                    </div>
                                                                    <div class="col-12 col-md-4 mb-2 mb-md-0">
                                                                        <span class="text-muted small">Proveedor</span><br>
                                                                        <strong>{{ $inventory->supplierProduct->supplier->name }}</strong>
                                                                    </div>
                                                                    <div class="col-12 col-md-4">
                                                                        <span class="text-muted small">Cantidad actual</span><br>
                                                                        <strong>{{ $inventory->quantity }}</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="supplier" value="{{ $inventory->supplierProduct->supplier->name }}">
                                                            <input type="hidden" name="item_name" value="{{ $inventory->supplierProduct->item->name }}">
                                                            <input type="hidden" name="current_quantity" value="{{ $inventory->quantity }}">

                                                            <p>¿Estás seguro que deseas eliminar esta cantidad del inventario?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
