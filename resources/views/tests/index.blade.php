@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'consultations.index', 'name' => 'Consultas Médicas', 'active' => true],
    ['route' => 'patients.index', 'name' => 'Pacientes', 'active' => false],
]"/>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5>Nueva Consulta Médica</h5>
            <div class="card p-3 mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <h5 >Datos del Paciente</h5>
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
                        <h5 >Información Médica</h5>
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <label for="symptoms">Síntomas y Motivo de Consulta</label>
                        <textarea name="symptoms" id="symptoms" class="form-control"
                                  rows="3" placeholder="" required></textarea>
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <label for="observations">Observaciones y Examen Físico</label>
                        <textarea name="observations" id="observations" class="form-control"
                                  rows="3" placeholder=""></textarea>
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
                        <h5>Tratamiento y Medicamentos</h5>
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <label for="treatment">Tratamiento Indicado</label>
                        <textarea name="treatment" id="treatment" class="form-control"
                                  rows="3"></textarea>
                    </div>
                                        <div class="col-md-12 mt-3">
                        <label>Medicamentos Recetados</label>
                        <div id="medications-container">
                            <div class="medication-item row mb-2">
                                <div class="col-md-5">
                                    <select name="medications[0][product_id]" class="form-control medication-select">
                                        <option value="">Seleccionar medicamento</option>

                                    </select>
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

                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Consulta</button>
                            <a href="#" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </div>


                </div>
            </div>
            <form action=""  method="POST">
                @csrf
            </form>
        </div>
    </div>
</div>
<x-delete-alert />

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Agregar medicamento
    let medicationIndex = 1;
    document.getElementById('add-medication').addEventListener('click', function() {
        const container = document.getElementById('medications-container');
        const newItem = document.createElement('div');
        newItem.className = 'medication-item row mb-2';
        newItem.innerHTML = `
            <div class="col-md-5">
                <select name="medications[${medicationIndex}][product_id]" class="form-control medication-select">
                    <option value="">Seleccionar medicamento</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="medications[${medicationIndex}][quantity]"
                       class="form-control" placeholder="Cantidad" min="1">
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medicationIndex}][instructions]"
                       class="form-control" placeholder="Instrucciones">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-medication">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        medicationIndex++;

        // Habilitar botón de eliminar del primer item si hay más de uno
        if (medicationIndex > 1) {
            document.querySelector('.remove-medication').disabled = false;
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-medication') ||
            e.target.parentElement.classList.contains('remove-medication')) {
            const button = e.target.classList.contains('remove-medication') ?
                          e.target : e.target.parentElement;
            const item = button.closest('.medication-item');
            item.remove();


            if (document.querySelectorAll('.medication-item').length === 1) {
                document.querySelector('.remove-medication').disabled = true;
            }
        }
    });


});
</script>
@endpush

<style>
.medication-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}
.medication-item:last-child {
    border-bottom: none;
}
</style>
@endsection
