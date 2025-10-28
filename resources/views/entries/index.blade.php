@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => false],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => true],
    ['route' => 'inventories.history', 'name' => 'Historial', 'active' => false],
]"/>
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="entries-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-log-in-circle'></i></div>
                <div>
                    <h5 class="mb-1">Entradas por Proveedor</h5>
                    <div class="text-muted small">Selecciona un proveedor para ingresar productos al inventario.</div>
                </div>
            </div>
    
        </div>

        <div class="card-body">
            <div class="row g-3">
                @foreach($suppliers as $supplier)
                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch">
                        <div class="card supplier-card border-0 shadow-xs w-100 mb-2">
                            @if(!empty($supplier->image_path))
                                <img class="card-img-top img-fluid" src="{{ asset('storage/' . $supplier->image_path) }}" alt="{{ $supplier->name }}" style="object-fit: cover; height: 180px;">
                            @else
                                <div class="supplier-placeholder d-flex align-items-center justify-content-center">
                                    <i class='bx bx-buildings'></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-center mb-1 text-truncate" title="{{ $supplier->name }}">{{ $supplier->name }}</h6>
                                <div class="text-muted small text-center mb-2"><i class='bx bx-user me-1'></i> {{ $supplier->promoter_name ?: '—' }}</div>
                                <div class="mt-auto d-flex justify-content-center">
                                    <a href="{{ route('inventory.entriesItems', ['supplier' => $supplier->id]) }}" class="btn btn-outline-primary btn-sm"><i class='bx bx-log-in'></i> Ingresar Productos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.entries-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
.supplier-card .supplier-placeholder{ height: 180px; background: #f1f3f5; color:#adb5bd; font-size: 42px; }
.shadow-xs{ box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
</style>
@endsection
