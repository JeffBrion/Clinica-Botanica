<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventories\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;

class SalesController extends Controller
{
    //
    public function index( $pagination = 15)
    {
        $inventories = Inventory::all();

        return view('sales.index', compact('inventories'));
    }

  public function store(Request $request)
{
    $validatedData = $request->validate([
        'items' => 'required|array',
        'items.*.inventory_id' => 'required|integer|exists:inventories,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'client_name' => 'sometimes|string|max:255', // ← Validación opcional
    ]);

    $sale = DB::transaction(function () use ($validatedData) {
        $sale = Sale::create([
            'sale_date' => now(),
            'client_name' => $validatedData['client_name'] ?? 'Cliente General',
            'created_by' => Auth::id(),
        ]);

        // Resto del código igual...
        foreach ($validatedData['items'] as $item) {
            $sale->details()->create([
                'inventory_id' => $item['inventory_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_by' => Auth::id(),
            ]);

            $inventory = Inventory::find($item['inventory_id']);
            if ($inventory) {
                $inventory->quantity -= $item['quantity'];
                if ($inventory->quantity < 0) {
                    throw new \Exception("La cantidad vendida excede el stock disponible para el producto: {$inventory->id}");
                }
                $inventory->save();
            }
        }

        return $sale;
    });

    return redirect()->route('sales.bill', ['sale' => $sale->id])->with('success', 'Venta registrada correctamente.');
}

  public function bill($saleId)
{

    if (session()->has('saleData')) {
        $saleData = session('saleData');
        return view('sales.bill', ['sale' => $saleData]);
    }


    $sale = Sale::find($saleId);
    return view('sales.bill', ['sale' => $sale]);
}

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));

    }
  public function history($pagination = 15)
{
    $sales = Sale::orderBy('sale_date', 'desc')->paginate($pagination);
    return view('sales.history', compact('sales'));
}
}
