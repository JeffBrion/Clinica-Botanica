<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventories\Inventory;

class SalesController extends Controller
{
    //
    public function index( $pagination = 15)
    {
        $inventories = Inventory::where('status', 'Entrada')
            ->orderBy('created_at', 'desc')
            ->paginate($pagination);
        return view('sales.index', compact('inventories'));
    }

    public function store(Request $request)
    {
     
        $items = $request->input('items', []);

        $saleData = [
            'supplier' => 'Proveedor 1', // Puedes ajustar esto dinámicamente
            'items' => $items,
        ];

        // Guardamos los datos de la venta en la sesión para recuperarlos en el método `bill`
        session(['saleData' => $saleData]);

        return redirect()->route('sales.bill', ['sale' => 1])->with('success', 'Venta registrada correctamente.');
    }

    public function bill($sale)
    {
        // Recuperamos los datos de la venta desde la sesión
        $saleData = session('saleData', []);

        return view('sales.bill', ['sale' => $saleData]);
    }
}
