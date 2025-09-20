@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('inventories.entries') }}" class="btn btn-secondary mb-3">Regresar</a>
    <div class="card p-3 mt-2">
        <h4>Productos del proveedor</h4>

        @if($items->isEmpty())
            <div class="alert alert-info">
                No hay items asignados a este proveedor.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Producto</th>
                        <th>Precio de Compra</th>
                        <th>Precio de Venta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->supplier?->name }}</td>
                            <td>{{ $item->item?->name }}</td>
                            <td>{{ $item->buy_price }}</td>

                            <td>{{ $item->sell_price }}</td>
                            <td>
                                <button
                                    class="btn btn-outline-warning btn-sm add-product"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->item?->name }}"
                                    data-buy-price="{{ $item->buy_price }}"
                                    data-sell-price="{{ $item->sell_price }}">
                                    Ingresar Producto
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="card p-3 mt-4">
        <h4>Formulario de Productos Seleccionados</h4>
        <form id="selected-products-form" method="POST" action="{{ route('inventories.store') }}">
            @csrf
            <table class="table table-bordered" id="selected-products-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio de Compra</th>
                        <th>Precio de Venta</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Cantidad</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">

                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Guardar Productos</button>
        </form>
    </div>
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
                    <td>${buyPrice}</td>
                    <td>${sellPrice}</td>
                    <td>
                        <input type="date" name="products[${productId}][expiration_date]" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="products[${productId}][quantity]" class="form-control" min="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-product" data-id="${productId}">Eliminar</button>
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
<x-delete-alert />
@endsection
