<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Services\Inventories\InventoryService;
use Illuminate\Http\Request;

use App\Models\Inventories\Inventory;
use App\Models\Suppliers\Supplier;
use App\Models\Suppliers\SupplierProduct;

class InventoriesController extends Controller
{
    public function index( $pagination = 15)
    {
        $inventories = Inventory::where('status', 'Entrada')->orderBy('created_at', 'desc')->paginate($pagination);

        return view('inventories.index', compact('inventories'));
    }

    public function entries()
    {
        $suppliers = Supplier::orderBy('created_at', 'asc')->get();
        return view('entries.index', compact('suppliers'));
    }
    public function entriesItems($supplier)
    {
        $supplier = Supplier::find($supplier);
        $items = SupplierProduct::where('supplier_id', $supplier->id)->with('item')->get();
        return view('entries.show', compact('items', 'supplier'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'products' => 'required|array',
            'products.*.supplier_product_id' => 'required|exists:supplier_products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.expiration_date' => 'required|date',
        ]);

        $response = InventoryService::makeInventory($request);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al agregar el Producto',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto agregado correctamente',
            'type' => 'success',
        ]);
    }

    public function history()
    {
        $inventories = Inventory::orderBy('created_at', 'desc')->paginate(15);

        return view('inventories.history', compact('inventories'));
    }

  public function historydelete(Request $request)
    {
        $response = InventoryService::historyDelete($request->all());

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al eliminar el Producto',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto Eliminado correctamente',
            'type' => 'success',
        ]);
    }
}
