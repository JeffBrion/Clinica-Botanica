@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <div class="row g-3">
   
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-building-house'></i></div>
                        <div>
                            <h5 class="mb-0">Ingresar Proveedor</h5>
                            <small class="text-muted">Registra un nuevo proveedor en el sistema.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ Route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre de la organización</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-store-alt'></i></span>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="promoter_name" class="form-label">Nombre del promotor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-user'></i></span>
                                    <input type="text" name="promoter_name" id="promoter_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="description" class="form-label">Descripción</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-align-left'></i></span>
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Dirección</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-map'></i></span>
                                    <input type="text" name="address" id="address" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-phone'></i></span>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-envelope'></i></span>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="website" class="form-label">Página web</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-globe'></i></span>
                                    <input type="text" name="website" id="website" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">Imagen</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success"><i class='bx bx-plus-medical'></i> Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listado: Proveedores -->
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden mt-1">
                <div class="suppliers-hero d-flex flex-wrap align-items-center justify-content-between p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-box'></i></div>
                        <div>
                            <h5 class="mb-1">Proveedores</h5>
                            <div class="text-muted small">Listado de proveedores registrados.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <span class="badge rounded-pill bg-success-subtle text-success fw-semibold px-3 py-2">
                            <i class='bx bx-layer me-1'></i> {{ method_exists($suppliers, 'total') ? $suppliers->total() : count($suppliers) }} en total
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        @foreach($suppliers as $supplier)
                            <div class="col-md-4 col-lg-3 d-flex align-items-stretch">
                                <div class="card supplier-card border-0 shadow-xs w-100 mb-3">
                                    @if(!empty($supplier->image_path))
                                        <img class="card-img-top img-fluid" src="{{ asset('storage/' . $supplier->image_path) }}" alt="{{ $supplier->name }}" style="object-fit: cover; height: 180px;">
                                    @else
                                        <div class="supplier-placeholder d-flex align-items-center justify-content-center">
                                            <i class='bx bx-buildings'></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title mb-1 text-truncate" title="{{ $supplier->name }}">{{ $supplier->name }}</h6>
                                        <div class="text-muted small mb-2"><i class='bx bx-user me-1'></i> {{ $supplier->promoter_name ?: '—' }}</div>
                                        <div class="mt-auto d-flex justify-content-between">
                                            <a href="{{ route('suppliers.show', ['supplier' => $supplier]) }}" class="btn btn-outline-primary btn-sm"><i class='bx bx-show'></i> Ver</a>
                                            <button class="delete-button btn btn-outline-danger btn-sm" data-url="{{ route('suppliers.delete', ['supplier' => $supplier]) }}"><i class='bx bx-trash'></i> Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-delete-alert />

<style>
.hero-icon{ width: 40px; height: 40px; background:#198754; color:#fff; font-size: 20px; }
.suppliers-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.supplier-card .supplier-placeholder{ height: 180px; background: #f1f3f5; color:#adb5bd; font-size: 42px; }
.shadow-xs{ box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
</style>
@endsection
