@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="entries-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-log-in-circle'></i></div>
                <div>
                    <h5 class="mb-1">Productos del Proveedor</h5>
                    <div class="text-muted small">Selecciona productos para ingresar al inventario.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                <a href="{{ route('inventories.entries') }}" class="btn btn-outline-secondary btn-sm"><i class='bx bx-arrow-back'></i> Regresar</a>
            </div>
        </div>

        <div class="card-body">
            @if($items->isEmpty())
                <div class="alert alert-info mb-0">
                    No hay ítems asignados a este proveedor.
                </div>
            @else
                <div class="row g-2 mb-2">
                    <div class="col-12">
                        <x-search-bar :table="'products_table'"/>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" id="products_table">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Proveedor</th>
                                <th>Producto</th>
                                <th class="text-end" style="width: 160px;">Precio Compra</th>
                                <th class="text-end" style="width: 160px;">Precio Venta</th>
                                <th style="width: 160px;">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->supplier?->name }}</td>
                                    <td class="fw-medium">{{ $item->item?->name }}</td>
                                    <td class="text-end">{{ $item->buy_price }}</td>
                                    <td class="text-end">{{ $item->sell_price }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm btn-outline-primary add-product"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->item?->name }}"
                                            data-buy-price="{{ $item->buy_price }}"
                                            data-sell-price="{{ $item->sell_price }}">
                                            <i class='bx bx-plus'></i> Ingresar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm p-3 mt-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:18px;"><i class='bx bx-list-check'></i></div>
            <h5 class="mb-0">Productos Seleccionados</h5>
        </div>
        <form id="selected-products-form" method="POST" action="{{ route('inventories.store') }}">
            @csrf
            <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
            <div class="table-responsive">
                <table class="table table-striped table-hover m-0" id="selected-products-table">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-end" style="width: 160px;">Precio Compra</th>
                            <th class="text-end" style="width: 160px;">Precio Venta</th>
                            <th style="width: 200px;">Fecha de Vencimiento</th>
                            <th style="width: 140px;">Cantidad</th>
                            <th style="width: 110px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success"><i class='bx bx-save'></i> Guardar Productos</button>
            </div>
        </form>
    </div>
</div>

<x-delete-alert />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedProductsTable = document.querySelector('#selected-products-table tbody');

        document.querySelectorAll('.add-product').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.id;
                const productName = this.dataset.name;
                const buyPrice = this.dataset.buyPrice;
                const sellPrice = this.dataset.sellPrice;

                if (document.querySelector(`#product-row-${productId}`)) {
                    alert('Este producto ya ha sido agregado.');
                    return;
                }

                const row = document.createElement('tr');
                row.id = `product-row-${productId}`;
                row.innerHTML = `
                    <td>${productName}</td>
                    <td class="text-end">${buyPrice}</td>
                    <td class="text-end">${sellPrice}</td>
                    <td>
                        <input type="date" name="products[${productId}][expiration_date]" class="form-control" placeholder="YYYY-MM-DD">
                    </td>
                    <td>
                        <input type="number" name="products[${productId}][quantity]" class="form-control" min="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-product" data-id="${productId}"><i class='bx bx-trash'></i></button>
                    </td>
                    <input type="hidden" name="products[${productId}][supplier_product_id]" value="${productId}">
                    <input type="hidden" name="products[${productId}][buy_price]" value="${buyPrice}">
                    <input type="hidden" name="products[${productId}][sell_price]" value="${sellPrice}">
                `;

                selectedProductsTable.appendChild(row);


                row.querySelector('.remove-product').addEventListener('click', function () {
                    row.remove();
                });
            });
        });
    });
    </script>

<style>
.entries-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
@endsection
