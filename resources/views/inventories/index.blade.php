@extends('layouts.app')
@section('content')
<x-sub-navbar :links="[
    ['route' => 'inventories.index', 'name' => 'Inventario', 'active' => true],
    ['route' => 'inventories.entries', 'name' => 'Entradas', 'active' => false],        
]"/>


@endsection