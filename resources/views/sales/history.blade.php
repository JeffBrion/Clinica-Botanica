@extends('layouts.app')

@section('content')
<x-sub-navbar :links="[
    ['route' => 'sales.index', 'name' => 'Realizar Venta', 'active' => false],
    ['route' => 'sales.history', 'name' => 'Ventas', 'active' => true],
]"/>
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="sales-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-receipt'></i></div>
                <div>
                    <h5 class="mb-1">Historial de Ventas</h5>
                    <div class="text-muted small">Consulta y busca ventas realizadas.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm"><i class='bx bx-cart'></i> Realizar venta</a>
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
                            <th style="width: 200px;">Fecha</th>
                            <th>Cliente</th>
                            <th>Vendido por</th>
                            <th style="width: 120px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->sale_date }}</td>
                                <td>{{ $sale->client_name ?? 'N/A' }}</td>
                                <td>{{ $sale->user?->name ?? 'Usuario Eliminado' }}</td>
                                <td>
                                    <a href="{{ route('sales.bill', ['sale' => $sale]) }}" class="btn btn-outline-primary btn-sm" title="Ver boleta"><i class='bx bxs-show'></i> Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.sales-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
