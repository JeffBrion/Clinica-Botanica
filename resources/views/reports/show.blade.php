@extends('Layouts.app')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12">
                <style>
                    .report-hero {
                        background: linear-gradient(135deg, #4f46e5 0%, #22c55e 100%);
                        color: #fff;
                        position: relative;
                    }
                    .report-hero .badge {
                        background: rgba(255,255,255,0.2) !important;
                        color: #fff !important;
                        backdrop-filter: saturate(180%) blur(4px);
                    }
                    .report-stat {
                        border: 1px solid rgba(0,0,0,0.05);
                        border-radius: 14px;
                        padding: 14px 16px;
                        background: #fff;
                        height: 100%;
                    }
                    .report-stat small {
                        color: #6b7280;
                        font-weight: 600;
                        letter-spacing: .3px;
                    }
                    .report-stat .value {
                        font-weight: 700;
                        color: #111827;
                    }
                    .report-illustration {
                        width: 140px;
                        height: 140px;
                        opacity: .95;
                    }
                </style>

                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                    <div class="report-hero p-4 p-md-5 d-flex align-items-center justify-content-between">
                        <div class="me-4">
                            <span class="badge rounded-pill mb-2">Detalle del Reporte</span>
                            <h2 class="h4 mb-2">{{ $report->report_type }}</h2>
                            <p class="mb-0" style="color: rgba(255,255,255,.85)">Generado el {{ $report->create_date }}</p>
                            <div class="mt-3 d-flex gap-2 flex-wrap">
                                <button id="exportExcelButtonTop" class="btn btn-outline-light export-excel-btn">
                                    <span class="me-1" aria-hidden="true">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 3v12m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5 21h14a2 2 0 0 0 2-2v-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                    Exportar a Excel
                                </button>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <!-- Ilustración inline SVG para evitar dependencias de imágenes -->
                            <svg class="report-illustration" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustración de reporte">
                                <defs>
                                    <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9"/>
                                        <stop offset="100%" stop-color="#e5e7eb" stop-opacity="0.8"/>
                                    </linearGradient>
                                </defs>
                                <rect x="10" y="20" width="180" height="140" rx="16" fill="url(#g1)"/>
                                <rect x="28" y="40" width="60" height="12" rx="6" fill="#a3a3a3"/>
                                <rect x="28" y="60" width="144" height="8" rx="4" fill="#c7c7c7"/>
                                <rect x="28" y="76" width="120" height="8" rx="4" fill="#d4d4d4"/>
                                <rect x="28" y="92" width="144" height="8" rx="4" fill="#e5e5e5"/>
                                <!-- Gráfico -->
                                <path d="M32 140 L64 112 L96 124 L128 96 L160 108" stroke="#22c55e" stroke-width="6" fill="none" stroke-linecap="round"/>
                                <circle cx="64" cy="112" r="4" fill="#22c55e"/>
                                <circle cx="96" cy="124" r="4" fill="#22c55e"/>
                                <circle cx="128" cy="96" r="4" fill="#22c55e"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="report-stat">
                                    <small>Tipo de Reporte</small>
                                    <div class="value mt-1">{{ $report->report_type }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="report-stat">
                                    <small>Generado el</small>
                                    <div class="value mt-1">{{ $report->create_date }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="report-stat">
                                    <small>Fecha de Inicio</small>
                                    <div class="value mt-1">{{ $report->start_date }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="report-stat">
                                    <small>Fecha de Fin</small>
                                    <div class="value mt-1">{{ $report->end_date }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                     <div class="col-lg-12 mt-4">
            <h5>Reportes</h5>

            <div class="card p-3">
                        <div class="table-responsive mt-4">
                            @if($report->report_type === 'Ventas')
                                <table id="reportTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha de Venta</th>
                                            <th>Nombre del Cliente</th>
                                            <th>Total Vendido</th>
                                            <th>Usuario de la venta</th>
                                            <th>Fecha de Creación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datas as $data)
                                            <tr>
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->sale_date }}</td>
                                                <td>{{ $data->client_name }}</td>
                                                <td>C$ {{ $data->total_amount }}</td>
                                                <td>{{ $data->user->name ?? 'Usuario Eliminado' }}</td>
                                                <td>{{ $data->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif($report->report_type === 'Ingresos por Proveedor')
                                <table id="reportTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Producto</th>
                                            <th>Cantidad Ingresada</th>
                                            <th>Motivo</th>
                                            <th>Ingresado por</th>
                                            <th>Fecha de Ingreso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datas as $row)
                                            <tr>
                                                <td>{{ $row->supplier_name ?: 'Desconocido' }}</td>
                                                <td>{{ $row->item_name ?: 'Desconocido' }}</td>
                                                <td>{{ $row->quantity }}</td>
                                                <td>{{ $row->reason ?: 'N/A' }}</td>
                                                <td>{{ $row->user_name ?: 'N/A' }}</td>
                                                <td>{{ $row->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif($report->report_type === 'Movimientos de Inventario')
                                <table id="reportTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Proveedor</th>
                                            <th>Cantidad Eliminada</th>
                                            <th>Motivo</th>
                                            <th>Eliminado el</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datas as $inv)
                                            <tr>
                                                <td>{{ $inv->id }}</td>
                                                <td>{{ $inv->item_name ?: 'Desconocido' }}</td>
                                                <td>{{ $inv->supplier_name ?: 'Desconocido' }}</td>
                                                <td>{{ $inv->quantity }}</td>
                                                <td>{{ $inv->reason ?? 'N/A' }}</td>
                                                <td>{{ $inv->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-info">Tipo de reporte desconocido.</div>
                            @endif
                        </div>
                <div class="mt-2">

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" integrity="sha512-UvsxN6vRzT1nXsyH6J/zrsm3bPcC3H1pQ9a5xDqP1dLxJwP0lN0t9k5c9G7k6wZ7tQkz2e0nM9W9e4iYQ8s+5A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainBtn = document.getElementById('exportExcelButton');
            const extraBtns = document.querySelectorAll('.export-excel-btn');

            function buildRowsFromBlade() {
                const rows = [];

                @if($report->report_type === 'Ventas')
                    rows.push(["ID", "Fecha de Venta", "Nombre del Cliente", "Total Vendido", "Usuario de la Venta", "Fecha de Creación"]);
                    @foreach($datas as $data)
                        rows.push([
                            {{ (int) $data->id }},
                            "{{ addslashes($data->sale_date) }}",
                            "{{ addslashes($data->client_name) }}",

                            @php $amount = is_numeric($data->total_amount) ? $data->total_amount : null; @endphp
                            {{ $amount !== null ? (float) $amount : '"'.addslashes('C$ '.$data->total_amount).'"' }},
                            "{{ addslashes($data->user->name ?? 'Usuario Eliminado') }}",
                            "{{ addslashes($data->created_at) }}",
                        ]);
                    @endforeach
                @elseif($report->report_type === 'Ingresos por Proveedor')
                    rows.push(["Proveedor", "Producto", "Cantidad Ingresada", "Motivo", "Ingresado por", "Fecha de Ingreso"]);
                    @foreach($datas as $row)
                        rows.push([
                            "{{ addslashes($row->supplier_name ?? 'Desconocido') }}",
                            "{{ addslashes($row->item_name ?? 'Desconocido') }}",
                            {{ (int) $row->quantity }},
                            "{{ addslashes($row->reason ?? 'N/A') }}",
                            "{{ addslashes($row->user_name ?? 'N/A') }}",
                            "{{ addslashes($row->created_at) }}",
                        ]);
                    @endforeach
                @elseif($report->report_type === 'Movimientos de Inventario')
                    rows.push(["ID", "Producto", "Proveedor", "Cantidad Eliminada", "Motivo", "Eliminado el"]);
                    @foreach($datas as $inv)
                        rows.push([
                            {{ (int) $inv->id }},
                            "{{ addslashes($inv->item_name ?? 'Desconocido') }}",
                            "{{ addslashes($inv->supplier_name ?? 'Desconocido') }}",
                            {{ (int) $inv->quantity }},
                            "{{ addslashes($inv->reason ?? 'N/A') }}",
                            "{{ addslashes($inv->created_at) }}",
                        ]);
                    @endforeach
                @endif

                return rows;
            }

            function autoColWidths(rows) {
                const cols = rows[0] ? rows[0].length : 0;
                const widths = new Array(cols).fill(10);
                rows.forEach(r => {
                    r.forEach((cell, i) => {
                        const text = (cell === null || cell === undefined) ? '' : cell.toString();
                        widths[i] = Math.max(widths[i], text.length + 2);
                    });
                });
                return widths.map(w => ({ wch: w }));
            }


            function exportTableAsExcelHtml(tableEl, filename = 'reporte.xls') {

                const html = `\n<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns="http://www.w3.org/TR/REC-html40">\n<head><meta charset="utf-8"/></head>\n<body>\n${tableEl.outerHTML}\n</body>\n</html>`;
                const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }

            function exportExcel() {
                const table = document.getElementById('reportTable');
                if (!table) return;

                if (typeof XLSX === 'undefined' || !XLSX.utils || !XLSX.writeFile) {

                    exportTableAsExcelHtml(table, 'reporte_{{ $report->id ?? "tabla" }}.xls');
                    return;
                }


                const rows = buildRowsFromBlade();
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.aoa_to_sheet(rows);
                ws['!cols'] = autoColWidths(rows);
                XLSX.utils.book_append_sheet(wb, ws, 'Reporte');


                const meta = [
                    ["Tipo de Reporte", "{{ addslashes($report->report_type) }}"],
                    ["Generado el", "{{ addslashes($report->create_date) }}"],
                    ["Fecha de Inicio", "{{ addslashes($report->start_date) }}"],
                    ["Fecha de Fin", "{{ addslashes($report->end_date) }}"],
                    ["Registros", "{{ count($datas) }}"],
                ];
                const wsMeta = XLSX.utils.aoa_to_sheet(meta);
                wsMeta['!cols'] = autoColWidths(meta);
                XLSX.utils.book_append_sheet(wb, wsMeta, 'Metadatos');

                const filename = 'reporte_{{ $report->id ?? "tabla" }}.xlsx';
                XLSX.writeFile(wb, filename);
            }

            if (mainBtn) mainBtn.addEventListener('click', exportExcel);
            if (extraBtns && extraBtns.length) {
                extraBtns.forEach(btn => btn.addEventListener('click', exportExcel));
            }
        });
    </script>
@endsection
