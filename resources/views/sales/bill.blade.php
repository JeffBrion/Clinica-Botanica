@extends('layouts.app')

@section('content')

<script>
    document.getElementById('toggle-form').addEventListener('click', function() {
        const form = document.getElementById('consultation-form');
        form.style.display = form.style.display === 'none' ? 'flex' : 'none';
    });
</script>

<div class="invoice" style="font-family: Arial, sans-serif; max-width: 800px; margin: auto; border: 1px solid #ddd; padding: 20px;">
    <div class="invoice-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px;">
        <img src="{{ asset('img/Logo.png') }}" alt="Logo" style="max-width: 150px;">
        <div style="text-align: right;">
            <h1 style="color: #4CAF50; font-size: 24px; margin: 0;">Clinica Botanica Diagno-Salud</h1>
            <p style="margin: 5px 0; font-size: 14px;">Atendido por: {{ Auth::user()->name ?? 'N/A' }}</p>
            <p style="margin: 5px 0; font-size: 14px;">Fecha: {{ date('d/m/Y') }}</p>
            <p style="margin: 5px 0; font-size: 14px;">Dirección: Clínica Radiológica Santa Ana, Media cuadra al norte</p>
        </div>
    </div>



    <table class="invoice-items" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; max-height: 400px;">
        <thead>
            <tr style="background-color: #4CAF50; color: white;">
                <th style="padding: 10px; border: 1px solid #ddd;">Producto</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Proveedor</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Cantidad</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Precio Unitario</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Total</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($sale['items'] ?? null))
                @foreach ($sale['items'] as $item)
                    @if(is_array($item))
                    <tr style="background-color: {{ $loop->index % 2 == 0 ? '#f9f9f9' : '#fff' }};">
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $item['name'] ?? 'N/A' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $item['supplier'] ?? 'N/A' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $item['quantity'] ?? 0 }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ $item['price'] ?? 0 }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ ($item['quantity'] ?? 0) * ($item['price'] ?? 0) }}</td>
                    </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No hay productos disponibles.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="invoice-footer" style="text-align: right; font-size: 18px;">
        <p><strong>Total:</strong> {{ is_array($sale['items'] ?? null) ? array_sum(array_map(function($item) { return ($item['quantity'] ?? 0) * ($item['price'] ?? 0); }, $sale['items'])) : 0 }}</p>
    </div>
</div>
@endsection
