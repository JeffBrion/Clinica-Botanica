@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="d-flex align-items-center justify-content-between p-3" style="background:linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom:1px solid rgba(0,0,0,.05)">
            <div class="d-flex align-items-center gap-2">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#198754;color:#fff;font-size:20px"><i class='bx bx-data'></i></div>
                <div>
                    <h5 class="mb-0">Respaldos</h5>
                    <small class="text-muted">Genera, descarga, elimina e importa respaldos.</small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('backups.store') }}">
                    @csrf
                    <input type="hidden" name="type" value="sql">
                    <button class="btn btn-success"><i class='bx bx-save me-1'></i> Generar SQL</button>
                </form>
                <form method="POST" action="{{ route('backups.store') }}">
                    @csrf
                    <input type="hidden" name="type" value="json">
                    <button class="btn btn-outline-success"><i class='bx bx-data me-1'></i> Generar JSON</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if(session('message'))
                <div class="alert alert-{{ session('type', 'success') }} mb-3">
                    <i class='bx bx-info-circle me-1'></i>{{ session('message') }}
                </div>
            @endif

            <div class="row g-3">
                <div class="col-12 col-lg-7">
                    <h6 class="text-uppercase text-muted mb-2">Listado de respaldos</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Archivo</th>
                                    <th style="width:140px">Tamaño</th>
                                    <th style="width:180px">Fecha</th>
                                    <th style="width:180px" class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($files as $f)
                                    <tr>
                                        <td class="fw-medium"><i class='bx bx-file me-1'></i>{{ $f['name'] }}</td>
                                        <td>{{ number_format($f['size']/1024, 2) }} KB</td>
                                        <td>{{ \Carbon\Carbon::createFromTimestamp($f['updated'])->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('backups.download', $f['name']) }}" class="btn btn-outline-primary btn-sm"><i class='bx bxs-download'></i> Descargar</a>
                                            <form action="{{ route('backups.destroy', $f['name']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar respaldo?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm"><i class='bx bxs-trash-alt'></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No hay respaldos aún.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <h6 class="text-uppercase text-muted mb-2">Importar respaldo</h6>
                    <div class="p-3 border rounded-3 bg-light">
                        <form method="POST" action="{{ route('backups.import') }}" enctype="multipart/form-data" class="d-grid gap-2">
                            @csrf
                            <div class="form-text">Selecciona un archivo .sql o .json generado por el sistema.</div>
                            <input type="file" name="backup_file" class="form-control" accept=".sql,.json" required>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="truncate" id="truncate" checked>
                                <label class="form-check-label" for="truncate">Truncar tablas antes de importar</label>
                            </div>
                            <button class="btn btn-warning"><i class='bx bx-import me-1'></i> Importar</button>
                        </form>
                        <div class="small text-muted mt-2">
                            Nota: Para respaldos automáticos, podemos programar una tarea diaria en el servidor (cron) que ejecute este proceso.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
