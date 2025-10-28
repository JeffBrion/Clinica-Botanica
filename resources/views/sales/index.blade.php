@extends('layouts.app')

@section('content')
<x-sub-navbar :links="[
    ['route' => 'sales.index', 'name' => 'Realizar Venta', 'active' => true],
    ['route' => 'sales.history', 'name' => 'Ventas', 'active' => false],
]"/>
<div class="container mt-3">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="sales-hero d-flex flex-wrap align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center"><i class='bx bx-cart-alt'></i></div>
                <div>
                    <h5 class="mb-1">Registrar Ventas</h5>
                    <div class="text-muted small">Selecciona ítems del inventario y agrégalos al carrito.</div>
                </div>
            </div>

        </div>

        <div class="card-body">
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <x-search-bar :table="'users_table'"/>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                <table class="table table-hover m-0" id="users_table">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Producto</th>
                            <th class="text-end" style="width: 140px;">Stock</th>
                            <th>Proveedor</th>
                            <th>Descripción</th>
                            <th style="width: 140px;">Vender</th>
                            <th class="text-end" style="width: 140px;">Precio</th>
                            <th style="width: 140px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->id }}</td>
                                <td class="fw-medium">{{ $inventory->supplierProduct->item->name ?? 'N/A' }}</td>
                                <td class="text-end">{{ $inventory->quantity }}</td>
                                <td>{{ $inventory->supplierProduct->supplier->name ?? 'N/A' }}</td>
                                <td class="text-truncate" style="max-width: 280px;" title="{{ $inventory->supplierProduct->item->description ?? 'N/A' }}">{{ $inventory->supplierProduct->item->description ?? 'N/A' }}</td>
                                <td>
                                    <input type="number" class="form-control quantity-input" min="1" max="{{ $inventory->total_quantity }}" value="1">
                                </td>
                                <td class="text-end">{{ $inventory->supplierProduct->sell_price ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary add-to-cart-btn"
                                        data-product-name="{{ $inventory->supplierProduct->item->name ?? 'N/A' }}"
                                        data-product-price="{{ $inventory->supplierProduct->sell_price ?? 0 }}"
                                        data-supplier-name="{{ $inventory->supplierProduct->supplier->name ?? 'N/A' }}"
                                        data-inventory-id="{{ $inventory->id }}">
                                        <i class="bx bx-cart"></i> Agregar
                                    </button>

                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inventory->supplier_product_id }}">
                                        <i class='bx bx-trash'></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal-{{ $inventory->supplier_product_id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $inventory->supplier_product_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('inventories.history.delete') }}">
                                                @csrf
                                                <input type="hidden" name="supplier_product_id" value="{{ $inventory->supplier_product_id }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel-{{ $inventory->supplier_product_id }}"><i class='bx bx-trash me-1'></i> Eliminar productos del grupo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="quantity-{{ $inventory->supplier_product_id }}" class="form-label">Cantidad a eliminar</label>
                                                        <input type="number" class="form-control" id="quantity-{{ $inventory->supplier_product_id }}" name="quantity" min="1" max="{{ $inventory->total_quantity }}" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{-- {{ $inventories->links() }} --}}
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-3 mt-4">
        <div class="d-flex align-items-center gap-2">
            <div class="hero-icon rounded-circle d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:18px;"><i class='bx bx-basket'></i></div>
            <h5 class="mb-0">Carrito</h5>
        </div>
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
                    <th>id</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody id="cart-items">

                </tbody>
            </table>
            </div>


            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#clientModal">
                Registrar Ventas
            </button>

            <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clientModalLabel">Confirmar Venta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="clientName" class="form-label">Nombre del Cliente</label>
                                <input type="text" class="form-control" id="clientName" name="client_name"
                                       value="Cliente General" required>
                                <small class="form-text text-muted">Ingrese el nombre del cliente o deje el nombre por defecto</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="confirmSale">Confirmar Venta</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const cartContainer = document.getElementById('cart-items');
                const clientModal = new bootstrap.Modal(document.getElementById('clientModal'));
                const clientNameInput = document.getElementById('clientName');
                const confirmSaleBtn = document.getElementById('confirmSale');
                const salesForm = document.getElementById('sales-form');

                document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const productName = this.getAttribute('data-product-name');
                        const productPrice = parseFloat(this.getAttribute('data-product-price'));
                        const supplierName = this.getAttribute('data-supplier-name');
                        const inventoryId = this.getAttribute('data-inventory-id');
                        const quantityInput = this.closest('tr').querySelector('.quantity-input');
                        const quantity = parseInt(quantityInput.value);

                        if (quantity <= 0 || isNaN(quantity)) {
                            alert('Por favor, ingrese una cantidad válida.');
                            return;
                        }


                        let existingRow = Array.from(cartContainer.children).find(row => {
                            const rowInventoryId = row.querySelector('.product-id').textContent;
                            return rowInventoryId === inventoryId;
                        });

                        if (existingRow) {

                            let quantityCell = existingRow.querySelector('.product-quantity');
                            let currentQuantity = parseInt(quantityCell.textContent);
                            quantityCell.textContent = currentQuantity + quantity;


                            let totalCell = existingRow.querySelector('.product-total');
                            totalCell.textContent = ((currentQuantity + quantity) * productPrice).toFixed(2);


                            let quantityInput = existingRow.querySelector('input[name$="[quantity]"]');
                            quantityInput.value = currentQuantity + quantity;
                        } else {

                            const row = document.createElement('tr');
                            const itemIndex = cartContainer.children.length;
                            row.innerHTML = `
                                <td class="product-name">${productName}</td>
                                <td class="product-supplier">${supplierName}</td>
                                <td class="product-quantity">${quantity}</td>
                                <td class="product-price">${productPrice.toFixed(2)}</td>
                                <td class="product-total">${(quantity * productPrice).toFixed(2)}</td>
                                <td class="product-id">${inventoryId}</td>
                                <td>
                                    <input type="hidden" name="items[${itemIndex}][inventory_id]" value="${inventoryId}">
                                    <input type="hidden" name="items[${itemIndex}][name]" value="${productName}">
                                    <input type="hidden" name="items[${itemIndex}][supplier]" value="${supplierName}">
                                    <input type="hidden" name="items[${itemIndex}][quantity]" value="${quantity}">
                                    <input type="hidden" name="items[${itemIndex}][price]" value="${productPrice}">
                                    <button type="button" class="btn btn-sm btn-danger remove-from-cart-btn">Eliminar</button>
                                </td>
                            `;
                            cartContainer.appendChild(row);


                            row.querySelector('.remove-from-cart-btn').addEventListener('click', function () {
                                row.remove();
                            });
                        }
                    });
                });

                confirmSaleBtn.addEventListener('click', function() {
                    const cartRows = document.querySelectorAll('#cart-items tr');
                    const clientName = clientNameInput.value.trim();

                    if (cartRows.length === 0) {
                        alert('El carrito está vacío. Agregue productos antes de registrar la venta.');
                        return;
                    }

                    if (!clientName) {
                        alert('Por favor, ingrese el nombre del cliente.');
                        return;
                    }


                    if (!document.querySelector('input[name="client_name"]')) {
                        const clientInput = document.createElement('input');
                        clientInput.type = 'hidden';
                        clientInput.name = 'client_name';
                        clientInput.value = clientName;
                        salesForm.appendChild(clientInput);
                    } else {
                        document.querySelector('input[name="client_name"]').value = clientName;
                    }


                    salesForm.submit();
                });

                salesForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const cartRows = document.querySelectorAll('#cart-items tr');
                    if (cartRows.length === 0) {
                        alert('El carrito está vacío. Agregue productos antes de registrar la venta.');
                        return;
                    }


                    clientModal.show();
                });
            });
        </script>
    </div>
</div>
@endsection

<style>
.sales-hero{ background: linear-gradient(135deg, rgba(25,135,84,0.10) 0%, rgba(25,135,84,0.02) 100%); border-bottom: 1px solid rgba(0,0,0,0.05); }
.hero-icon{ width: 44px; height: 44px; background:#198754; color:#fff; font-size: 22px; }
thead.sticky-top th{ position: sticky; top: 0; z-index: 1; }
</style>
