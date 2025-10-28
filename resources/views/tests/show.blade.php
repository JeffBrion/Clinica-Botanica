@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'test.index', 'name' => 'Nueva Consulta', 'active' => false],
    ['route' => 'test.show', 'name' => 'Historial', 'active' => true],

]"/>
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="consult-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-history'></i></div>
                <div>
                    <h5 class="mb-1">Historial de Consultas</h5>
                    <div class="text-muted small">Busca y revisa consultas registradas.</div>
                </div>
            </div>

        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('test.show') }}" class="row g-2 mb-3">
                <div class="col-md-7">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white"><i class='bx bx-search'></i></span>
                        <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Buscar por paciente o tipo">
                    </div>
                </div>
                <div class="col-md-5 d-grid d-md-flex gap-2 justify-content-md-end">
                    <button class="btn btn-success" type="submit"><i class='bx bx-filter-alt'></i> Buscar</button>
                    <a href="{{ route('test.show') }}" class="btn btn-outline-secondary"><i class='bx bx-reset'></i> Limpiar</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle m-0" id="users_table">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 160px;">Fecha</th>
                            <th>Paciente</th>
                            <th>Tipo</th>
                            <th>Crónica</th>
                            <th class="text-end" style="width: 140px;">Peso (kg)</th>
                            <th>Presión</th>
                            <th class="text-end" style="width: 110px;">Ritmo</th>
                            <th>Síntomas</th>
                            <th class="text-center" style="width: 120px;">Medicamentos</th>
                            <th style="width: 150px;">Receta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $c)
                            <tr>
                                <td>{{ optional($c->consultation_date)->format('Y-m-d H:i') }}</td>
                                <td>{{ $c->patient_name }}</td>
                                <td>
                                    @php
                                        $labels = [
                                            'primera_vez' => 'Primera vez',
                                            'control' => 'Control',
                                            'emergencia' => 'Emergencia',
                                            'seguimiento' => 'Seguimiento',
                                        ];
                                    @endphp
                                    <span class="badge bg-secondary">{{ $labels[$c->consultation_type] ?? $c->consultation_type }}</span>
                                </td>
                                <td>
                                    @if($c->is_chronic)
                                        <span class="badge text-bg-danger">Sí</span>
                                    @else
                                        <span class="badge text-bg-success">No</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ $c->weight ? number_format($c->weight, 2) : '—' }}</td>
                                <td>{{ $c->blood_pressure ?? '—' }}</td>
                                <td class="text-end">{{ $c->heart_rate ? $c->heart_rate . ' bpm' : '—' }}</td>
                                <td title="{{ $c->symptoms }}">{{ \Illuminate\Support\Str::limit($c->symptoms, 60) }}</td>
                                <td class="text-center"><span class="badge text-bg-info">{{ $c->medications_count }}</span></td>
                                <td>
                                    <a href="{{ route('test.prescription', $c) }}" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">
                                        <i class='bx bx-printer'></i> Ver/Imprimir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">Sin consultas registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-2">
                {{ $consultations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.consult-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
