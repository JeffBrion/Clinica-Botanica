@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => true],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => false],
    ['route' => 'inventories.history', 'name' => 'Historial', 'active' => false],

]"/>

<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="inventory-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-package'></i></div>
                <div>
                    <h5 class="mb-1">Productos en Inventario</h5>
                    <div class="text-muted small">Consulta, busca y gestiona el stock.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                    <i class='bx bx-layer me-1'></i> {{ method_exists($inventories, 'total') ? $inventories->total() : count($inventories) }} ítems
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-12">
                    <x-search-bar :table="'users_table'"/>
                </div>
            </div>

            <!-- Tabla Desktop -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover m-0" id="users_table">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Nombre</th>
                            <th class="text-end" style="width: 120px;">Cantidad</th>
                            <th>Proveedor</th>
                            <th class="text-end" style="width: 160px;">Precio compra</th>
                            <th class="text-end" style="width: 160px;">Precio venta</th>
                            <th style="width: 110px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                            <tr>
                                <td class="fw-medium">{{ $inventory->supplierProduct->item->name ?? 'N/A' }}</td>
                                <td class="text-end fw-semibold">{{ $inventory->total_quantity }}</td>
                                <td>{{ $inventory->supplierProduct->supplier->name ?? 'N/A' }}</td>
                                <td class="text-end">{{ $inventory->supplierProduct->buy_price ?? 'N/A' }}</td>
                                <td class="text-end">{{ $inventory->supplierProduct->sell_price ?? 'N/A' }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inventory->supplier_product_id }}">
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
                                                        <h5 class="modal-title" id="deleteModalLabel-{{ $inventory->supplier_product_id }}"><i class='bx bx-trash me-1'></i> Eliminar cantidad</h5>
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

            <!-- Lista Móvil -->
            <div class="d-md-none">
                @foreach($inventories as $inventory)
                    <div class="card border-0 shadow-xs mb-2">
                        <div class="card-body d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="fw-semibold">{{ $inventory->supplierProduct->item->name ?? 'N/A' }}</div>
                                <div class="text-muted small">Proveedor: {{ $inventory->supplierProduct->supplier->name ?? 'N/A' }}</div>
                                <div class="text-muted small">Compra: {{ $inventory->supplierProduct->buy_price ?? 'N/A' }} · Venta: {{ $inventory->supplierProduct->sell_price ?? 'N/A' }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $inventory->total_quantity }}</div>
                                <div class="text-muted small">Cantidad</div>
                                <button type="button" class="btn btn-outline-danger btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inventory->supplier_product_id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal (reutilizado) -->
                    <div class="modal fade" id="deleteModal-{{ $inventory->supplier_product_id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $inventory->supplier_product_id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('inventories.delete', ['inventory' => $inventory->supplier_product_id]) }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel-{{ $inventory->supplier_product_id }}"><i class='bx bx-trash me-1'></i> Eliminar cantidad</h5>
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
                @endforeach
            </div>

            <div class="mt-3">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.inventory-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
.shadow-xs{ box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
@endsection
