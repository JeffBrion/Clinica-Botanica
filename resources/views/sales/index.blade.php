@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-12 mt-4">
        <h5>Registrar Ventas</h5>
        <div class="card p-3">
            <div class="row justify-content-end">
                <div class="col-md-12">
                    <x-search-bar :table="'users_table'"/>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-striped table-hover m-0" id="users_table">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Cantidad en stock</th>
                            <th>Proveedor</th>
                            <th>Descripción</th>
                            <th>Cantidad a vender</th>
                            <th>Precio</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->supplierProduct?->item->name }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>{{$inventory->supplierProduct?->supplier->name}}</td>
                                <td>{{ $inventory->supplierProduct?->item->description }} </td>
                                <td>
                                    <input type="number" class="form-control quantity-input"
                                           min="1" max="{{ $inventory->quantity }}"
                                           value="1">
                                </td>
                                <td>{{ $inventory->supplierProduct?->sell_price }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary add-to-cart-btn"
                                        data-product-name="{{ $inventory->supplierProduct?->item->name }}"
                                        data-product-price="{{ $inventory->supplierProduct?->sell_price }}"
                                        data-supplier-name="{{ $inventory->supplierProduct?->supplier->name }}">
                                    Agregar al Carrito
                                    <i class="bx bx-cart"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{ $inventories->links() }}
            </div>
        </div>
    </div>

    <div class="card p-3 mt-4">
        <h5 class="mt-2"> Carrito </h5>
        <form action="{{ route('sales.store') }}" method="POST" id="sales-form">
            @csrf
            <div id="cart-container">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Proveedor</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody id="cart-items">
                <!-- Items del carrito se agregarán aquí dinámicamente -->
                </tbody>
            </table>
            </div>
            <button type="submit" class="btn btn-success mt-3">Registrar Ventas</button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const cartContainer = document.getElementById('cart-items');

                document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const productName = this.getAttribute('data-product-name');
                        const productPrice = parseFloat(this.getAttribute('data-product-price'));
                        const supplierName = this.getAttribute('data-supplier-name');
                        const quantityInput = this.closest('tr').querySelector('.quantity-input');
                        const quantity = parseInt(quantityInput.value);

                        if (quantity <= 0 || isNaN(quantity)) {
                            alert('Por favor, ingrese una cantidad válida.');
                            return;
                        }

                        // Buscar si ya existe el mismo producto del mismo proveedor
                        let existingRow = Array.from(cartContainer.children).find(row => {
                            const rowProduct = row.querySelector('.product-name').textContent;
                            const rowSupplier = row.querySelector('.product-supplier').textContent;
                            return rowProduct === productName && rowSupplier === supplierName;
                        });

                        if (existingRow) {
                            // Actualizar cantidad si ya existe
                            let quantityCell = existingRow.querySelector('.product-quantity');
                            let currentQuantity = parseInt(quantityCell.textContent);
                            quantityCell.textContent = currentQuantity + quantity;

                            // Actualizar total
                            let totalCell = existingRow.querySelector('.product-total');
                            totalCell.textContent = ((currentQuantity + quantity) * productPrice).toFixed(2);
                        } else {
                            // Crear nuevo item en el carrito
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="product-name">${productName}</td>
                                <td class="product-supplier">${supplierName}</td>
                                <td class="product-quantity">${quantity}</td>
                                <td class="product-price">${productPrice.toFixed(2)}</td>
                                <td class="product-total">${(quantity * productPrice).toFixed(2)}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-from-cart-btn">Eliminar</button>
                                    <button type="button" class="btn btn-sm btn-warning decrement-quantity-btn">-</button>
                                </td>
                            `;
                            cartContainer.appendChild(row);

                            // Evento para eliminar item
                            row.querySelector('.remove-from-cart-btn').addEventListener('click', function () {
                                row.remove();
                            });

                            // Evento para disminuir cantidad
                            row.querySelector('.decrement-quantity-btn').addEventListener('click', function () {
                                let quantityCell = row.querySelector('.product-quantity');
                                let currentQuantity = parseInt(quantityCell.textContent);

                                if (currentQuantity > 1) {
                                    quantityCell.textContent = currentQuantity - 1;
                                    let totalCell = row.querySelector('.product-total');
                                    totalCell.textContent = ((currentQuantity - 1) * productPrice).toFixed(2);
                                } else {
                                    row.remove();
                                }
                            });
                        }
                    });
                });

                // Manejar el envío del formulario
                document.getElementById('sales-form').addEventListener('submit', function(e) {
                    // Eliminar inputs ocultos previos
                    document.querySelectorAll('.cart-hidden-input').forEach(el => el.remove());

                    const cartRows = document.querySelectorAll('#cart-items tr');
                    cartRows.forEach((row, idx) => {
                        const name = row.querySelector('.product-name').textContent;
                        const supplier = row.querySelector('.product-supplier').textContent;
                        const quantity = row.querySelector('.product-quantity').textContent;
                        const price = row.querySelector('.product-price').textContent;

                        this.insertAdjacentHTML('beforeend', `
                            <input type="hidden" name="items[${idx}][name]" value="${name}" class="cart-hidden-input">
                            <input type="hidden" name="items[${idx}][supplier]" value="${supplier}" class="cart-hidden-input">
                            <input type="hidden" name="items[${idx}][quantity]" value="${quantity}" class="cart-hidden-input">
                            <input type="hidden" name="items[${idx}][price]" value="${price}" class="cart-hidden-input">
                        `);
                    });

                    if (cartRows.length === 0) {
                        e.preventDefault();
                        alert('El carrito está vacío. Agregue productos antes de registrar la venta.');
                    }
                });
            });
        </script>
    </div>
</div>
@endsection
