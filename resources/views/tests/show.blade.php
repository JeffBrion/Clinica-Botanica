@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'test.index', 'name' => 'Nueva Consulta', 'active' => false],
    ['route' => 'test.show', 'name' => 'Historial', 'active' => true],

]"/>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Historial de Consultas</h5>

            <form method="GET" action="{{ route('test.show') }}" class="row g-2 mt-2">
                <div class="col-md-6">
                    <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Buscar por paciente o tipo">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100" type="submit">Buscar</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('test.show') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('test.index') }}" class="btn btn-primary w-100">Nueva Consulta</a>
                </div>
            </form>

            <div class="card p-3 mt-3">

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Paciente</th>
                                <th>Tipo</th>
                                <th>Crónica</th>
                                <th>Peso (kg)</th>
                                <th>Presión</th>
                                <th>Ritmo</th>
                                <th>Síntomas</th>
                                <th>Medicamentos</th>
                                <th>Receta</th>
                            
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
                                            <span class="badge bg-danger">Sí</span>
                                        @else
                                            <span class="badge bg-success">No</span>
                                        @endif
                                    </td>
                                    <td>{{ $c->weight ? number_format($c->weight, 2) : '—' }}</td>
                                    <td>{{ $c->blood_pressure ?? '—' }}</td>
                                    <td>{{ $c->heart_rate ? $c->heart_rate . ' bpm' : '—' }}</td>
                                    <td title="{{ $c->symptoms }}">{{ \Illuminate\Support\Str::limit($c->symptoms, 60) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $c->medications_count }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('test.prescription', $c) }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">
                                            <i class='bx bx-printer'></i> Ver/Imprimir
                                        </a>
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">Sin consultas registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $consultations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
