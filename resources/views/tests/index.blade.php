@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'test.index', 'name' => 'Nueva Consulta', 'active' => true],
    ['route' => 'test.show', 'name' => 'Historial', 'active' => false],
]"/>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Nueva Consulta Médica</h5>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('test.store') }}" method="POST" id="consultation-form">
                @csrf
            <div class="card p-3 mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="section-title"><i class='bx bx-user-circle me-1'></i> Datos del Paciente</h5>
                    </div>

                        <div class="form-group col-md-4 mt-3">
                            <label for="patient_name">Nombre Completo</label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control" required>
                        </div>

                    <div class="form-group col-md-4 mt-3">
                        <label for="consultation_date">Fecha de Consulta</label>
                        <input type="datetime-local" name="consultation_date" id="consultation_date"
                               class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="form-group col-md-4 mt-3">
                        <label for="consultation_type">Tipo de Consulta</label>
                        <select name="consultation_type" id="consultation_type" class="form-control" required>
                            <option value="primera_vez">Primera Vez</option>
                            <option value="control">Control</option>
                            <option value="emergencia">Emergencia</option>
                            <option value="seguimiento">Seguimiento</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card p-3 mt-2">
                <div class="row">
                     <div class="col-md-12 mt-4">
                        <h5 class="section-title"><i class='bx bx-notepad me-1'></i> Información Médica</h5>
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <label for="symptoms">Síntomas y Motivo de Consulta</label>
                        <textarea name="symptoms" id="symptoms" class="form-control"
                                  rows="3" placeholder="" required></textarea>
                    </div>

                    <div class="form-group col-md-3 mt-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="is_chronic" name="is_chronic">
                            <label class="form-check-label" for="is_chronic">
                                ¿Enfermedad crónica?
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-3 mt-3">
                        <label for="weight">Peso (kg)</label>
                        <input type="number" step="0.1" min="0" max="1000" name="weight" id="weight" class="form-control" placeholder="Ej: 70.5">
                    </div>

                    <div class="form-group col-md-3 mt-3">
                        <label for="blood_pressure">Presión arterial</label>
                        <input type="text" name="blood_pressure" id="blood_pressure" class="form-control" placeholder="Ej: 120/80">
                    </div>

                    <div class="form-group col-md-3 mt-3">
                        <label for="heart_rate">Ritmo cardiaco (bpm)</label>
                        <input type="number" min="0" max="300" name="heart_rate" id="heart_rate" class="form-control" placeholder="Ej: 72">
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <label for="diagnosis">Diagnóstico</label>
                        <textarea name="diagnosis" id="diagnosis" class="form-control"
                                  rows="2" placeholder=""></textarea>
                    </div>
                </div>
            </div>
            <div class="card p-3 mt-3 mb-3">
                <div class="row">
                        <div class="col-md-12 mt-4">
                        <h5 class="section-title"><i class='bx bx-capsule me-1'></i> Tratamiento y Medicamentos</h5>
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <label for="treatment">Tratamiento Indicado</label>
                        <textarea name="treatment" id="treatment" class="form-control"
                                  rows="3"></textarea>
                    </div>
                                        <div class="col-md-12 mt-3">
                        <label>Medicamentos Recetados</label>
                        <div class="row medication-header text-secondary fw-semibold small g-0 mb-2 d-none d-md-flex">
                            <div class="col-md-5 ps-2">Medicamento</div>
                            <div class="col-md-2">Cantidad</div>
                            <div class="col-md-3">Instrucciones</div>
                            <div class="col-md-2">Acciones</div>
                        </div>
                        <div id="medications-container">
                            <div class="medication-item row mb-2">
                                <div class="col-md-5">
                                    <input type="text" class="form-control medication-search mb-1" placeholder="Buscar medicamento...">
                                    <select name="medications[0][product_id]" class="form-control medication-select">
                                        <option value="">Seleccionar medicamento</option>
                                    </select>
                                    <small class="text-muted d-block stock-hint"></small>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="medications[0][quantity]"
                                           class="form-control" placeholder="Cantidad" min="1">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="medications[0][instructions]"
                                           class="form-control" placeholder="Instrucciones">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-medication" disabled>
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-medication" class="btn btn-sm btn-outline-secondary mt-2">
                            <i class='bx bx-plus'></i> Agregar Medicamento
                        </button>

                        <div class="d-flex justify-content-end mt-2">
                            <small class="text-muted" id="medication-summary">Medicamentos: 0 | Cantidad total: 0</small>
                        </div>

                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Consulta</button>
                            <a href="{{ route('test.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </div>


                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<x-delete-alert />

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.MEDICATION_ITEMS = @json($medicationItems ?? []);

    function buildOptions(items) {
        let html = '<option value="">Seleccionar medicamento</option>';
        items.forEach(i => {
            const base = i.code ? `${i.name} (${i.code})` : i.name;
            const stockTxt = (typeof i.stock === 'number') ? ` — Stock: ${i.stock}` : '';
            const label = `${base}${stockTxt}`;
            html += `<option value="${i.id}">${label}</option>`;
        });
        return html;
    }

    function initMedicationSelect(selectEl) {
        const items = Array.isArray(window.MEDICATION_ITEMS) ? window.MEDICATION_ITEMS : [];
        if (!items.length || !selectEl) return;
        selectEl.innerHTML = buildOptions(items);
    }

    function filterMedicationSelect(selectEl, term) {
        const items = Array.isArray(window.MEDICATION_ITEMS) ? window.MEDICATION_ITEMS : [];
        const t = (term || '').toLowerCase();
        const filtered = items.filter(i =>
            i.name.toLowerCase().includes(t) || (i.code && i.code.toLowerCase().includes(t))
        );
        selectEl.innerHTML = buildOptions(filtered);
    }

    document.querySelectorAll('.medication-select').forEach(function (sel) {
        initMedicationSelect(sel);
        updateRowStock(sel.closest('.medication-item'));
    });

    function findItemById(id) {
        const items = Array.isArray(window.MEDICATION_ITEMS) ? window.MEDICATION_ITEMS : [];
        id = parseInt(id, 10);
        return items.find(i => parseInt(i.id, 10) === id) || null;
    }

    function updateRowStock(row) {
        if (!row) return;
        const selectEl = row.querySelector('.medication-select');
        const qtyEl = row.querySelector('input[name*="[quantity]"]');
        const hint = row.querySelector('.stock-hint');
        if (!selectEl || !qtyEl || !hint) return;

        const selectedId = selectEl.value;
        const item = selectedId ? findItemById(selectedId) : null;
        const stock = item && typeof item.stock === 'number' ? item.stock : null;
        if (stock !== null) {
            qtyEl.max = String(stock);
            if (qtyEl.value && parseInt(qtyEl.value, 10) > stock) {
                qtyEl.value = String(stock);
            }
            hint.textContent = `Stock disponible: ${stock}`;
        } else {
            qtyEl.removeAttribute('max');
            hint.textContent = '';
        }
    }

    function recalcSummary() {
        const rows = document.querySelectorAll('.medication-item');
        let count = 0;
        let totalQty = 0;
        rows.forEach(row => {
            const selectEl = row.querySelector('.medication-select');
            const qtyEl = row.querySelector('input[name*="[quantity]"]');
            if (selectEl && selectEl.value) count++;
            if (qtyEl && qtyEl.value) totalQty += parseInt(qtyEl.value, 10) || 0;
        });
        const summary = document.getElementById('medication-summary');
        if (summary) summary.textContent = `Medicamentos: ${count} | Cantidad total: ${totalQty}`;
    }

    let medicationIndex = document.querySelectorAll('.medication-item').length;

    const addBtn = document.getElementById('add-medication');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const container = document.getElementById('medications-container');
            if (!container) return;

            const newItem = document.createElement('div');
            newItem.className = 'medication-item row mb-2';
            newItem.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control medication-search mb-1" placeholder="Buscar medicamento...">
                    <select name="medications[${medicationIndex}][product_id]" class="form-control medication-select">
                        <option value="">Seleccionar medicamento</option>
                    </select>
                    <small class="text-muted d-block stock-hint"></small>
                </div>
                <div class="col-md-2">
                    <input type="number" name="medications[${medicationIndex}][quantity]" class="form-control" placeholder="Cantidad" min="1">
                </div>
                <div class="col-md-3">
                    <input type="text" name="medications[${medicationIndex}][instructions]" class="form-control" placeholder="Instrucciones">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-medication">
                        <i class='bx bx-trash'></i>
                    </button>
                </div>
            `;
            container.appendChild(newItem);

            const newSelect = newItem.querySelector('.medication-select');
            initMedicationSelect(newSelect);
            updateRowStock(newItem);
            medicationIndex++;
            recalcSummary();

            const items = document.querySelectorAll('.medication-item');
            if (items.length > 1) {
                const firstRemoveBtn = items[0].querySelector('.remove-medication');
                if (firstRemoveBtn) firstRemoveBtn.disabled = false;
            }
        });
    }

    document.addEventListener('click', function (e) {
        const removeBtn = e.target.closest && e.target.closest('.remove-medication');
        if (removeBtn) {
            const item = removeBtn.closest('.medication-item');
            if (item) item.remove();

            const items = document.querySelectorAll('.medication-item');
            if (items.length === 1) {
                const onlyBtn = items[0].querySelector('.remove-medication');
                if (onlyBtn) onlyBtn.disabled = true;
            }
            recalcSummary();
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target && e.target.classList && e.target.classList.contains('medication-search')) {
            const row = e.target.closest('.medication-item');
            if (!row) return;
            const selectEl = row.querySelector('.medication-select');
            if (!selectEl) return;
            filterMedicationSelect(selectEl, e.target.value);
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList && e.target.classList.contains('medication-select')) {
            const row = e.target.closest('.medication-item');
            updateRowStock(row);
            recalcSummary();
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target && e.target.name && e.target.name.includes('[quantity]')) {
            const max = parseInt(e.target.max, 10);
            const val = parseInt(e.target.value || '0', 10);
            if (!isNaN(max) && val > max) {
                e.target.value = String(max);
            }
            recalcSummary();
        }
    });

    const itemsAtLoad = document.querySelectorAll('.medication-item');
    if (itemsAtLoad.length === 1) {
        const firstRemoveBtn = itemsAtLoad[0].querySelector('.remove-medication');
        if (firstRemoveBtn) firstRemoveBtn.disabled = true;
    }
    recalcSummary();
});
</script>
@endpush

<style>
.section-title {
    display: flex;
    align-items: center;
    gap: 6px;
}

.medication-header {
    border-bottom: 1px solid #eee;
}

.medication-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}
.medication-item:last-child {
    border-bottom: none;
}
</style>
@endsection
