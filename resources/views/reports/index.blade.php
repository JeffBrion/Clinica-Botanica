@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                <i class='bx bx-check-circle me-1'></i>{{ session('success') }}
            </div>
        @endif

        <style>
            .hero-reports {
                background: linear-gradient(135deg, #22c55e 0%, #4f46e5 100%);
                color: #fff;
            }
            .table-sticky thead th {
                position: sticky;
                top: 0;
                z-index: 2;
                background: #f8fafc;
            }
        </style>

        <div class="card border-0 shadow rounded-4 overflow-hidden mt-4">
            <div class="hero-reports p-4 p-md-5 d-flex align-items-center justify-content-between">
                <div class="me-4">
                    <span class="badge rounded-pill bg-white text-dark mb-2" style="opacity:.9">Reportes</span>
                    <h2 class="h4 mb-2">Generar reportes</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,.9)">Elige tipo y rango de fechas para crear un nuevo reporte.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class='bx bxs-report' style="font-size:64px; opacity:.9"></i>
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

        <div class="card border-0 shadow rounded-4 mt-4">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <div class="col-8">
                    <x-search-bar :table="'reports_table'"/>
                </div>
                <h5 class="mb-0">Historial de reportes</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive table-sticky">
                    <table class="table table-hover align-middle mb-0" id="reports_table">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Generado</th>
                                <th>Creado por</th>
                                <th class="text-end">Opciones</th>
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
                                        <a href="{{ route('reports.show', ['report' => $report]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class='bx bxs-show me-1'></i> Ver
                                        </a>
                                        {{-- <button class="delete-button btn btn-sm btn-outline-danger" data-url="{{ route('reports.delete', ['report' => $report]) }}"><i class='bx bxs-trash-alt'></i></button> --}}
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
            </div>
            <div class="card-footer bg-white">
                {{ $reports->links() }}
            </div>
        </div>

        <x-delete-alert />
    </div>
@endsection
