@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="alerts-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon d-inline-flex align-items-center justify-content-center rounded-circle">
                    <i class='bx bx-bell'></i>
                </div>
                <div>
                    <h5 class="mb-1">Alertas de Inventario</h5>
                    <div class="text-muted small">Bajo stock y próximos a vencer.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                    <i class='bx bx-layer me-1'></i> {{ $alerts->count() }} bajo stock
                </span>
                @isset($expiring)
                <span class="badge rounded-pill bg-danger-subtle text-danger fw-semibold px-3 py-2">
                    <i class='bx bx-time-five me-1'></i> {{ $expiring->count() }} por vencer ≤ {{ $expDays }} días
                </span>
                @endisset
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('inventories.alerts') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-6">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white"><i class='bx bx-search'></i></span>
                        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por nombre o código">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">Umbral</span>
                        <input type="number" name="threshold" value="{{ $threshold }}" min="0" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 d-grid d-md-flex gap-2 justify-content-md-end">
                    <button class="btn btn-success" type="submit"><i class='bx bx-filter-alt'></i> Filtrar</button>
                    <a href="{{ route('inventories.alerts') }}" class="btn btn-outline-secondary"><i class='bx bx-reset'></i> Limpiar</a>
                </div>
            </form>

            <h6 class="text-uppercase text-muted mb-2"><i class='bx bx-layer me-1'></i> Bajo stock</h6>
            @include('inventories.partials._stock_alerts')

            <hr class="my-4" />

            <h6 class="text-uppercase text-muted mb-2"><i class='bx bx-time-five me-1'></i> Próximos a vencer@endisset</h6>
            @include('inventories.partials._expiring_alerts')

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary"><i class='bx bx-arrow-back'></i> Volver a Inventario</a>
            </div>
        </div>
    </div>
</div>

<style>
.alerts-hero{
    background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%);
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
.hero-icon{
    width: 44px; height: 44px; background: #198754; color: #fff; font-size: 22px;
}
.code-pill{ display:inline-block; padding: 4px 8px; background:#f1f3f5; border-radius: 6px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
.status-badge{ display:inline-flex; align-items:center; gap:6px; padding: 4px 10px; border-radius: 999px; font-weight: 600; font-size: .85rem; }
.status-badge.success{ color:#146c43; background: #d1e7dd; }
.status-badge.warning{ color:#664d03; background:#fff3cd; }
.status-badge.danger{ color:#842029; background:#f8d7da; }
.empty-state{ display:inline-flex; flex-direction:column; align-items:center; }
.empty-state i{ font-size: 44px; color:#ced4da; }
.shadow-xs{ box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
@endsection
