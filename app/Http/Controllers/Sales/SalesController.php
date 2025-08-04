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

      $requests = request()->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'sale_date' => 'required|date',
        ]);

        

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
    }
}
