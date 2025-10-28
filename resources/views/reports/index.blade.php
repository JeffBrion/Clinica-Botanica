@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                <i class='bx bx-check-circle me-1'></i>{{ session('success') }}
            </div>
        @endif

        <style>
            /* Alineado al estilo de Items */
            .reports-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
            .hero-icon{ width: 40px; height: 40px; background:#198754; color:#fff; font-size: 20px; }
            .table-sticky thead th { position: sticky; top: 0; z-index: 1; background: #f8fafc; }
        </style>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bxs-report'></i></div>
                    <div>
                        <h5 class="mb-0">Generar Reporte</h5>
                        <small class="text-muted">Elige tipo y rango de fechas para crear un nuevo reporte.</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('reports.generate') }}" class="row g-3">
                    @csrf
                    <div class="col-12 col-md-4">
                        <label for="start_date" class="form-label">Fecha de inicio</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="end_date" class="form-label">Fecha de fin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-calendar-event'></i></span>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="report_type" class="form-label">Tipo de reporte</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-category'></i></span>
                            <select class="form-select" id="report_type" name="report_type" required>
                                <option value="sales">Ventas</option>
                                <option value="supplier_income">Ingresos de Proveedores</option>
                                <option value="inventory_movements">Productos eliminados</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class='bx bx-line-chart me-1'></i> Generar reporte
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden mt-4">
            <div class="reports-hero d-flex flex-wrap align-items-center justify-content-between p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-list-ul'></i></div>
                    <div>
                        <h5 class="mb-1">Reportes</h5>
                        <div class="text-muted small">Listado de reportes generados.</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                    <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                        <i class='bx bx-layer me-1'></i> {{ method_exists($reports, 'total') ? $reports->total() : count($reports) }} en total
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-2">
                    <div class="col-12">
                        <x-search-bar :table="'reports_table'"/>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover m-0" id="reports_table">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Tipo</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Generado</th>
                                <th>Creado por</th>
                                <th style="width: 140px;" class="text-end">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>
                                        <span class="badge bg-success-subtle text-success" style="border:1px solid rgba(16,185,129,.25)">{{ $report->report_type }}</span>
                                    </td>
                                    <td>{{ $report->start_date }}</td>
                                    <td>{{ $report->end_date }}</td>
                                    <td>{{ $report->create_date }}</td>
                                    <td>{{ $report->user->name ?? 'N/A' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('reports.show', ['report' => $report]) }}" class="btn btn-outline-primary btn-sm" title="Ver"><i class='bx bxs-show'></i> Ver</a>
                                        {{-- <button class="delete-button btn btn-outline-danger btn-sm" data-url="{{ route('reports.delete', ['report' => $report]) }}" title="Eliminar"><i class='bx bxs-trash-alt'></i></button> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Aún no hay reportes generados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>

        <x-delete-alert />
    </div>
@endsection
