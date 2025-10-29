@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#198754;color:#fff;font-size:20px"><i class='bx bx-info-circle'></i></div>
                        <div>
                            <h5 class="mb-0">Acerca de</h5>
                            <small class="text-muted">Información del sistema y del proyecto.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Resumen del proyecto (desde Readme) -->
                    <div class="mb-3">
                        <h6 class="text-uppercase text-muted mb-2">Proyecto</h6>
                        <h4 class="mb-1">Sistema de Gestión de Inventarios - Clínica Botánica</h4>
                        <p class="mb-2">
                            Este proyecto es un sistema de gestión de inventarios desarrollado para la administración de productos, proveedores y entradas en una clínica botánica.
                            Permite visualizar, registrar y gestionar productos con información detallada como precios, cantidades y proveedores asociados.
                        </p>
                        <small class="text-muted">Proyecto de titulación elaborado por Jefferson Briones, Edward Milan y Eddy Sevilla.</small>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class='bx bx-cog text-success'></i>
                                    <strong>Funcionalidades principales</strong>
                                </div>
                                <ul class="mb-0 ps-3">
                                    <li>Gestión de inventarios: productos, cantidades y precios.</li>
                                    <li>Entradas de productos con fechas de vencimiento y cantidades.</li>
                                    <li>Paginación para grandes volúmenes de datos.</li>
                                    <li>Búsqueda dinámica por barra de búsqueda.</li>
                                    <li>Relaciones entre productos, proveedores y precios.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class='bx bxl-laravel text-danger'></i>
                                    <strong>Tecnologías utilizadas</strong>
                                </div>
                                <ul class="mb-0 ps-3">
                                    <li>Framework: Laravel 10</li>
                                    <li>Base de datos: MySQL</li>
                                    <li>Frontend: Blade Templates, Bootstrap</li>
                                    <li>Autenticación: Laravel Sanctum</li>
                                    <li>Interactividad: JavaScript</li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <!-- Información del sistema -->
                    <div class="mt-4">
                        <h6 class="text-uppercase text-muted mb-2">Sistema</h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="text-muted small">Aplicación</div>
                                    <div class="fw-semibold">{{ config('app.name') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="text-muted small">Usuario</div>
                                    <div class="fw-semibold">{{ Auth()->user()->name }}</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="text-muted small">Laravel</div>
                                    <div class="fw-semibold">{{ app()->version() }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="text-muted small">PHP</div>
                                    <div class="fw-semibold">{{ phpversion() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('users.showChangePassword') }}" class="btn btn-outline-success">
                            <i class='bx bx-key me-1'></i> Cambiar contraseña
                        </a>
                        <a href="/" class="btn btn-outline-primary">
                            <i class='bx bx-home-alt me-1'></i> Ir al panel
                        </a>
                        <a href="https://github.com/JeffBrion/Clinica-Botanica" target="_blank" class="btn btn-outline-dark">
                            <i class='bx bxl-github me-1'></i> Repositorio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
