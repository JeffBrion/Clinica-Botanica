@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => false],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => true],        
]"/>
<div class="container">
    <div class="row card p-3 mt-2">
        <div class="col-lg-12 mt-4">
            <h5>Proveedores</h5>
                <div class="row mt-2 d-flex justify-content-between"> 
                    @foreach($suppliers as $supplier)
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card" style="width: 100%;">
                            <img class="card-img-top img-fluid" src="{{ asset('storage/' . $supplier->image_path) }}" alt="{{ $supplier->name }}" alt="Card image cap" style="object-fit: cover; height: 200px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center">{{ $supplier->name }}</h5>
                                <p class="card-text"><strong>Promotor:</strong> {{ $supplier->promoter_name }}</p>
                                <div class="mt-auto d-flex justify-content-between">
                                <a href="" class="btn btn-outline-primary">Ingresar Productos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection