@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12">
                <h5>Generar Reportes</h5>
                <div class="card p-3">

                    <form method="post" action="{{ route('reports.generate') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Fecha de inicio</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Fecha de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="col-md-4">
                                <label for="report_type" class="form-label">Tipo de Reporte</label>
                                <select class="form-control" id="report_type" name="report_type" required>
                                    <option value="sales">Ventas</option>
                                    <option value="supplier_income">Ingresos de Proveedores</option>
                                    <option value="inventory_movements">Productos eliminados</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Generar Reporte</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <h5>Reportes</h5>
            <div class="card p-3">
                <div class="row justify-content-end">
                    <div class="col-md-12">
                        <x-search-bar :table="'reports_table'"/>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-0" id="reports_table">
                        <thead>
                            <tr>
                                <th>Tipo de Reporte</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Generado el</th>
                                <th>Creado por</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $report->report_type }}</td>
                                    <td>{{ $report->start_date }}</td>
                                    <td>{{ $report->end_date }}</td>
                                    <td>{{ $report->create_date }}</td>
                                    <td>{{$report->user->name ?? 'N/A'}}</td>
                                   <td>
                                        <a href="{{route('reports.show', ['report' => $report])}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                        {{-- <button class="delete-button btn btn-danger" data-url="{{route('reports.delete', ['report' => $report])}}"><i class='bx bxs-trash-alt'></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('report_search');
        const resultsList = document.getElementById('report_search_results');
        const select = document.getElementById('report_id');
        let reports = [
            @foreach($reports as $report)
                {id: {{ $report->id }}, name: "{{ addslashes($report->report_type) }}"},
            @endforeach
        ];

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            resultsList.innerHTML = '';
            if (query.length === 0) {
                resultsList.style.display = 'none';
                return;
            }
            const filtered = reports.filter(rep => rep.name.toLowerCase().includes(query));
            if (filtered.length === 0) {
                resultsList.style.display = 'none';
                return;
            }
            filtered.forEach(rep => {
                const li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action';
                li.textContent = rep.name;
                li.onclick = function () {
                    select.value = rep.id;
                    searchInput.value = rep.name;
                    resultsList.style.display = 'none';
                };
                resultsList.appendChild(li);
            });
            resultsList.style.display = 'block';
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
                resultsList.style.display = 'none';
            }
        });
    });
</script>
<x-delete-alert />
