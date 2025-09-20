@extends('layouts.app')

@section('content')
<x-sub-navbar :links="[
    ['route' => 'sales.index', 'name' => 'Realizar Venta', 'active' => false],
    ['route' => 'sales.history', 'name' => 'Ventas', 'active' => true],
]"/>
<div class="container">
    <div class="col-lg-12 mt-4">
        <h5>Registrar Ventas</h5>
        <div class="card p-3">
            <div class="row justify-content-end">
                <div class="col-md-12">
                    <x-search-bar :table="'users_table'"/>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover m-0" id="users_table">
                    <thead>
                        <tr>
                            <th>Fecha de la venta</th>
                            <th>Nombre del Cliente</th>
                            <th>Vendido por</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->sale_date }}</td>
                                <td>{{ $sale->client_name?? 'N/A' }}</td>
                                <td>{{ $sale->user->name }}</td>
                                  <td>
                                        <a href="{{route('sales.bill', ['sale' => $sale])}}" class="btn btn-primary"><i class='bx bxs-show'></i></a>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{ $sales->links() }}
            </div>
        </div>
    </div>


</div>
@endsection
