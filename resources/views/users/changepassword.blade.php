@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5>Cambiar Contraseña</h5>
                <form action="{{Route('users.updatePassword')}}" class="card p-3 mt-2" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mt-3">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6 mt-3">
                            <label for="password_confirmation">Confirme Contraseña</label>
                            <input type="password" name="password_confirmation"  class="form-control">
                        </div>

                        <div class="col-md-12 mt-2">
                            <button type="submit" class="btn btn-outline-secondary">Cambiar Contrseña</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
