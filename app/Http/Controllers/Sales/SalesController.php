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

        $inventory = Inventory::find($validatedData['inventory_id']);
        if ($inventory->quantity < $validatedData['quantity']) {
            return redirect()->back()->withErrors(['quantity' => 'La cantidad solicitada excede el inventario disponible.']);
        }

        $inventory->quantity -= $validatedData['quantity'];
        $inventory->save();

        // Logic to send all data to the view 'bill.index'
        $saleData = [
            'inventory' => $inventory,
            'quantity' => $validatedData['quantity'],
            'customer_name' => $validatedData['customer_name'],
            'sale_date' => $validatedData['sale_date'],
        ];

        return redirect()->route('bill.index')->with('saleData', $saleData);

        return redirect()->route('bill.index')->with('success', 'Venta registrada correctamente.');
    }
}
