@extends('layouts.app')

@section('content')
<x-sub-navbar :links="[
    ['route' => 'test.index', 'name' => 'Nueva Consulta', 'active' => false],
    ['route' => 'test.show', 'name' => 'Historial', 'active' => false]
]"/>

<div class="invoice" style="font-family: Arial, sans-serif; max-width: 800px; margin: auto; border: 1px solid #ddd; padding: 20px; min-height: 600px;">
    <div class="invoice-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px;">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="max-width: 150px;" class="logo-img">
        <div style="text-align: right;">
            <h1 style="color: #4CAF50; font-size: 24px; margin: 0;">Clínica Botánica Diagno-Salud</h1>
            <p style="margin: 5px 0; font-size: 14px;">Atendido por: {{ optional($consultation->createdBy)->name ?? (auth()->user()->name ?? 'Usuario') }}</p>
            <p style="margin: 5px 0; font-size: 14px;">Fecha: {{ optional($consultation->consultation_date)->format('d/m/Y H:i') }}</p>
            <p style="margin: 5px 0; font-size: 14px;">Paciente: {{ $consultation->patient_name }}</p>
            <p style="margin: 5px 0; font-size: 14px;">Tipo: {{ $consultation->consultation_type }}</p>
        </div>
    </div>

    <div style="display:flex; gap: 12px; flex-wrap: wrap; margin-bottom: 10px; font-size: 14px;">
        <div><strong>Crónica:</strong> {!! $consultation->is_chronic ? '<span style="color:#c81e1e">Sí</span>' : 'No' !!}</div>
        <div><strong>Peso:</strong> {{ $consultation->weight ? number_format($consultation->weight, 2) . ' kg' : '—' }}</div>
        <div><strong>Presión:</strong> {{ $consultation->blood_pressure ?? '—' }}</div>
        <div><strong>Ritmo:</strong> {{ $consultation->heart_rate ? $consultation->heart_rate . ' bpm' : '—' }}</div>
    </div>

    @if($consultation->diagnosis)
        <div style="margin: 8px 0 14px; font-size: 14px;">
            <strong>Diagnóstico:</strong>
            <div>{{ $consultation->diagnosis }}</div>
        </div>
    @endif

    @if($consultation->treatment)
        <div style="margin: 8px 0 14px; font-size: 14px;">
            <strong>Tratamiento:</strong>
            <div>{{ $consultation->treatment }}</div>
        </div>
    @endif

    <div class="container-table">
        <table class="invoice-items" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #4CAF50; color: white;">
                    <th style="padding: 10px; border: 1px solid #ddd; text-align:left;">Medicamento</th>
                    <th style="padding: 10px; border: 1px solid #ddd; width:120px;">Cantidad</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Instrucciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultation->medications as $m)
                    <tr style="{{ $loop->index % 2 == 0 ? 'background-color: #f9f9f9;' : '' }}">
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ optional($m->item)->name ?? 'Medicamento' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $m->quantity }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $m->instructions ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No hay medicamentos recetados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <button onclick="printA6()" style="background-color: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">
            🖨️ Imprimir Receta (A6 Vertical)
        </button>
    </div>
</div>

<script>
function printA6() {
    const el = document.querySelector('.invoice');
    if (!el) return;
    el.classList.add('a6-format');
    window.print();
    setTimeout(() => el.classList.remove('a6-format'), 100);
}
</script>

<style>
@media print {
    @page { size: A6 portrait; margin: 0.5cm; }
    body * { visibility: hidden; }
    .invoice, .invoice * { visibility: visible; }
    /* A6 portrait is 105mm × 148mm */
    .invoice { position: absolute; left: 0; top: 0; width: 105mm; height: 148mm; padding: 10px; border: none; box-shadow: none; font-size: 10px; }
    .logo-img { max-width: 100px !important; height: auto; }
    h1{ font-size: 12px; }
    p{ font-size: 10px }
    .invoice-items { font-size: 10px; }
    .invoice-items th, .invoice-items td { padding: 4px !important; }
    button { display: none !important; }
}
</style>

@endsection
