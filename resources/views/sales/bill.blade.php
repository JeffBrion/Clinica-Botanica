@extends('layouts.app')

@section('content')

<script>
    document.getElementById('toggle-form').addEventListener('click', function() {
        const form = document.getElementById('consultation-form');
        form.style.display = form.style.display === 'none' ? 'flex' : 'none';
    });


    function printInvoice() {
        window.print();
    }
</script>

    <div class="invoice" style="font-family: Arial, sans-serif; max-width: 800px; margin: auto; border: 1px solid #ddd; padding: 20px;min-height: 600px;">
        <div class="invoice-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px;">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="max-width: 150px;" class="logo-img">
            <div style="text-align: right;">
                <h1 style="color: #4CAF50; font-size: 24px; margin: 0;">Clinica Botanica Diagno-Salud</h1>
                <p style="margin: 5px 0; font-size: 14px;">Atendido por: {{ Auth::user()->name ?? 'N/A' }}</p>
                <p style="margin: 5px 0; font-size: 14px;">Fecha: {{ date('d/m/Y') }}</p>
                <p style="margin: 5px 0; font-size: 14px;">Nombre del cliente: {{$sale->client_name}}</p>
                <p style="margin: 5px 0; font-size: 14px; ">De clínica Radiológica Santa Ana, Media cuadra al norte</p>

            </div>
        </div>
    <div class="container-table">
        <table class="invoice-items" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; max-height: 400px;">
            <thead>
                <tr style="background-color: #4CAF50; color: white;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Producto</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Cantidad</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Precio Unitario</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp

                @foreach($sale->details as $detail)
                    @php
                        $inventory = App\Models\Inventories\Inventory::find($detail->inventory_id);
                        $itemTotal = $detail->quantity * $detail->price;
                        $total += $itemTotal;
                    @endphp
                    <tr style="{{ $loop->index % 2 == 0 ? 'background-color: #f9f9f9;' : '' }}">
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $inventory->supplierProduct->item->name ?? 'Producto no encontrado' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $detail->quantity }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">C$ {{ number_format($detail->price, 2) }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">C$ {{ number_format($itemTotal, 2) }}</td>
                    </tr>
                @endforeach

                @if(count($sale->details) === 0)
                    <tr>
                        <td colspan="5" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No hay productos disponibles.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


        <div class="invoice-total" style="border-top: 2px solid #4CAF50; padding-top: 20px; margin-top: 30px;">

            <div style="display: flex; justify-content: flex-end;">
                <div style="width: 300px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 18px;">
                        <span style="font-weight: bold;">Total:</span>
                        <span>C$ {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>


        <div style="text-align: center; margin-top: 30px;">
            <button  onclick="printA5()" style="background-color: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">
                🖨️ Imprimir Factura
            </button>
        </div>

        <input type="hidden" name="total" value="{{ $total }}">

    </div>
    <script>
    function printInvoice() {
        window.print();
    }

    function printA5() {
        // Agregar clase específica para A5
        document.querySelector('.invoice').classList.add('a5-format');
        window.print();
        // Remover la clase después de imprimir
        setTimeout(() => {
            document.querySelector('.invoice').classList.remove('a5-format');
        }, 100);
    }


</script>

    <!-- Estilos para impresión -->

       <style>
    @media print {
        /* Forzar tamaño A5 */
        @page {
            size: A5;
            margin: 0.5cm;
        }

        body * {
            visibility: hidden;
        }
        .invoice, .invoice * {
            visibility: visible;
        }
        .invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 148mm;
            height: 210mm;
            padding: 10px;
            border: none;
            box-shadow: none;
            font-size: 10px;
        }
        .logo-img {
                max-width: 100px !important;
                height: auto;
            }
        h1{
            font-size: 12px;
        }
        p{
            font-size: 10px
        }
        .invoice-items {
            font-size: 10px;

        }
        .container-table{
            height: 400px;
        }

        .invoice-items th,
        .invoice-items td {
            padding: 4px !important;
        }

        button {
            display: none !important;
        }
    }

    /* Estilos para el botón de impresión automática */
    .auto-print {
        background-color: #007bff;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }

    .auto-print:hover {
        background-color: #0056b3;
    }
</style>

@endsection
