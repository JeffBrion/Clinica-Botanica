@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="mt-5">
                <div class="text-center">
                    <img src="{{ asset('img/Logo.png') }}" alt="Logo" class="img-fluid mb-4">
                    <div class="lato-regular">
                        <h1 class="responsive-h1">Bienvenidos a {{ config('app.name') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection