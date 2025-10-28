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
                    <h5 class="mb-1">Alertas de Stock</h5>
                    <div class="text-muted small">Productos en o por debajo del umbral definido.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                    <i class='bx bx-layer me-1'></i> {{ $alerts->count() }} alertas
                </span>
                <span class="badge rounded-pill bg-warning-subtle text-warning fw-semibold px-3 py-2">
                    <i class='bx bx-slider-alt me-1'></i> Umbral {{ $threshold }}
                </span>
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

            <!-- Tabla en desktop -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 120px;">Código</th>
                            <th>Producto</th>
                            <th class="text-end" style="width: 140px;">Stock</th>
                            <th class="text-end" style="width: 120px;">Umbral</th>
                            <th style="width: 140px;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alerts as $row)
                            @php
                                $isZero = (int) $row['stock'] === 0;
                                $isLow = (int) $row['stock'] <= (int) $threshold;
                            @endphp
                            <tr>
                                <td><span class="code-pill">{{ $row['code'] ?? '—' }}</span></td>
                                <td class="fw-medium">{{ $row['name'] }}</td>
                                <td class="text-end fw-semibold">{{ $row['stock'] }}</td>
                                <td class="text-end">{{ $threshold }}</td>
                                <td>
                                    @if($isZero)
                                        <span class="status-badge danger"><i class='bx bx-x-circle me-1'></i>Agotado</span>
                                    @elseif($isLow)
                                        <span class="status-badge warning"><i class='bx bx-error me-1'></i>Bajo</span>
                                    @else
                                        <span class="status-badge success"><i class='bx bx-check-circle me-1'></i>Ok</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class='bx bx-package'></i>
                                        <div class="mt-2">No hay alertas con el umbral seleccionado.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Lista en móvil -->
            <div class="d-md-none">
                @forelse($alerts as $row)
                    @php
                        $isZero = (int) $row['stock'] === 0;
                        $isLow = (int) $row['stock'] <= (int) $threshold;
                    @endphp
                    <div class="card mb-2 border-0 shadow-xs">
                        <div class="card-body d-flex justify-content-between align-items-center gap-2">
                            <div>
                                <div class="fw-semibold">{{ $row['name'] }}</div>
                                <div class="text-muted small">Código: <span class="text-monospace">{{ $row['code'] ?? '—' }}</span></div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $row['stock'] }}</div>
                                <div class="text-muted small">Umbral {{ $threshold }}</div>
                                <div class="mt-1">
                                    @if($isZero)
                                        <span class="status-badge danger"><i class='bx bx-x-circle me-1'></i>Agotado</span>
                                    @elseif($isLow)
                                        <span class="status-badge warning"><i class='bx bx-error me-1'></i>Bajo</span>
                                    @else
                                        <span class="status-badge success"><i class='bx bx-check-circle me-1'></i>Ok</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <div class="empty-state">
                            <i class='bx bx-package'></i>
                            <div class="mt-2">No hay alertas con el umbral seleccionado.</div>
                        </div>
                    </div>
                @endforelse
            </div>

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
