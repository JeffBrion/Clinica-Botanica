@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => false],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => false],
    ['route' => 'inventories.history', 'name' => 'Historial', 'active' => true],

]"/>
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="history-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-time-five'></i></div>
                <div>
                    <h5 class="mb-1">Historial de Productos</h5>
                    <div class="text-muted small">Entradas y salidas registradas del inventario.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                    <i class='bx bx-log-in me-1'></i> {{ is_countable($addedInventories ?? []) ? count($addedInventories) : 0 }} agregados
                </span>
                <span class="badge rounded-pill bg-danger-subtle text-danger fw-semibold px-3 py-2">
                    <i class='bx bx-log-out me-1'></i> {{ is_countable($deletedInventories ?? []) ? count($deletedInventories) : 0 }} eliminados
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <x-search-bar :table="'users_table'"/>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover m-0" id="users_table">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Producto</th>
                            <th class="text-end" style="width: 120px;">Cantidad</th>
                            <th>Proveedor</th>
                            <th style="width: 180px;">Fecha</th>
                            <th>Observación</th>
                            <th>Usuario</th>
                            <th style="width: 130px;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addedInventories as $entry)
                            <tr class="table-success">
                                <td class="fw-medium">{{ $entry->supplierProduct->item->name }}</td>
                                <td class="text-end">{{ $entry->quantity }}</td>
                                <td>{{ $entry->supplierProduct->supplier->name }}</td>
                                <td>{{ optional($entry->created_at)->format('Y-m-d H:i') }}</td>
                                <td class="text-truncate" style="max-width: 320px;" title="{{ $entry->reason }}">{{ $entry->reason }}</td>
                                <td>{{ $entry->create_by ?? 'admin' }}</td>
                                <td><span class="badge text-bg-success"><i class='bx bx-log-in me-1'></i>Agregado</span></td>
                            </tr>
                        @endforeach
                        @foreach($deletedInventories as $entry)
                            <tr class="table-danger">
                                <td class="fw-medium">{{ $entry->supplierProduct->item->name }}</td>
                                <td class="text-end">{{ $entry->quantity }}</td>
                                <td>{{ $entry->supplierProduct->supplier->name }}</td>
                                <td>{{ optional($entry->created_at)->format('Y-m-d H:i') }}</td>
                                <td class="text-truncate" style="max-width: 320px;" title="{{ $entry->reason }}">{{ $entry->reason }}</td>
                                <td>{{ $entry->create_by ?? 'admin' }}</td>
                                <td><span class="badge text-bg-danger"><i class='bx bx-log-out me-1'></i>Eliminado</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{-- {{ $inventories->links() }} --}}
            </div>
        </div>
    </div>
</div>
<style>
.history-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
@endsection
