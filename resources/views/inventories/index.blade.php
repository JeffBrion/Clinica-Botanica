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
                                <tr>
                                    <td>{{ $inventory->supplierProduct->item->name ?? 'N/A' }}</td>
                                    <td>{{ $inventory->total_quantity }}</td>
                                    <td>{{ $inventory->supplierProduct->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ $inventory->supplierProduct->buy_price ?? 'N/A' }}</td>
                                    <td>{{ $inventory->supplierProduct->sell_price ?? 'N/A' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inventory->supplier_product_id }}">
                                            <i class='bx bx-trash'></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $inventory->supplier_product_id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $inventory->supplier_product_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('inventories.delete', ['inventory' => $inventory->supplier_product_id]) }}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel-{{ $inventory->supplier_product_id }}">Eliminar cantidad de producto</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="supplier_product_id" value="{{ $inventory->supplier_product_id }}">
                                                            <div class="mb-3">
                                                                <label for="quantity-{{ $inventory->supplier_product_id }}" class="form-label">Cantidad a eliminar</label>
                                                                <input type="number" class="form-control" id="quantity-{{ $inventory->supplier_product_id }}" name="quantity" min="1" max="{{ $inventory->total_quantity }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="observation-{{ $inventory->supplier_product_id }}" class="form-label">Observación</label>
                                                                <textarea class="form-control" id="observation-{{ $inventory->supplier_product_id }}" name="reason" rows="3" required></textarea>
                                                            </div>
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
