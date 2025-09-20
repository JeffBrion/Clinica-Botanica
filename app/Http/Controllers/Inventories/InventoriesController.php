<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Services\Inventories\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Inventories\Inventory;
use App\Models\Inventories\DeletedInventory;
use App\Models\Suppliers\Supplier;
use App\Models\Suppliers\SupplierProduct;
use App\Models\Inventories\InventoryEntry;
use App\Models\Inventories\InventoryAdded;

class InventoriesController extends Controller
{
    public function index( $pagination = 15)
    {
        $inventories = Inventory::selectRaw('supplier_product_id, SUM(quantity) as total_quantity, MAX(expiration_date) as latest_expiration_date, MAX(created_at) as latest_created_at')
            ->where('status', 'Entrada')
            ->groupBy('supplier_product_id')
            ->orderBy('latest_created_at', 'desc')
            ->paginate($pagination);

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
            'products.*.expiration_date' => 'nullable|date',
        ]);

        $userId = Auth::id();

        foreach ($request->products as $product) {
            $inventory = Inventory::where('supplier_product_id', $product['supplier_product_id'])
                ->where('status', 'Entrada')
                ->first();

            if ($inventory) {
                $inventory->quantity += $product['quantity'];
                $inventory->save();
            } else {
                Inventory::create([
                    'supplier_product_id' => $product['supplier_product_id'],
                    'quantity' => $product['quantity'],
                    'status' => 'Entrada',
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'requested_date' => now(),
                    'expiration_date' => $product['expiration_date'] ?? now()->addYear(),
                ]);
            }

            InventoryAdded::create([
                'supplier_product_id' => $product['supplier_product_id'],
                'quantity' => $product['quantity'],
                'reason' => $product['reason'] ?? 'Ingreso de inventario',
                'added_by' => $userId,
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Productos agregados correctamente',
            'type' => 'success',
        ]);
    }

    public function history()
    {
        $deletedInventories = DeletedInventory::with(['supplierProduct', 'deletedBy'])->orderBy('deleted_at', 'desc')->get();
        $addedInventories = InventoryAdded::with(['supplierProduct', 'addedBy'])->orderBy('created_at', 'desc')->get();

        return view('inventories.history', compact('deletedInventories', 'addedInventories'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'supplier_product_id' => 'required|exists:supplier_products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        DeletedInventory::create([
            'supplier_product_id' => $request->supplier_product_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'deleted_by' => $userId,
            'deleted_at' => now(),
        ]);

        $remainingQuantity = $request->quantity;

        $inventories = Inventory::where('supplier_product_id', $request->supplier_product_id)
            ->where('status', 'Entrada')
            ->orderBy('expiration_date', 'asc')
            ->get();

        foreach ($inventories as $inventory) {
            if ($remainingQuantity <= 0) {
                break;
            }

            if ($inventory->quantity > $remainingQuantity) {
                $inventory->quantity -= $remainingQuantity;
                $inventory->save();
                $remainingQuantity = 0;
            } else {
                $remainingQuantity -= $inventory->quantity;
                $inventory->quantity = 0; // Mark as depleted but keep the record
                $inventory->save();
            }
        }

        if ($remainingQuantity > 0) {
            return redirect()->back()->with([
                'message' => 'Cantidad a eliminar excede el inventario disponible.',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto eliminado correctamente',
            'type' => 'success',
        ]);
    }

    public function addEntry(Request $request)
    {
        $request->validate([
            'supplier_product_id' => 'required|exists:supplier_products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        $inventory = Inventory::where('supplier_product_id', $request->supplier_product_id)
            ->where('status', 'Entrada')
            ->first();

        if ($inventory) {
            $inventory->quantity += $request->quantity;
            $inventory->save();
        } else {
            Inventory::create([
                'supplier_product_id' => $request->supplier_product_id,
                'quantity' => $request->quantity,
                'status' => 'Entrada',
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Entrada registrada correctamente',
            'type' => 'success',
        ]);
    }
}
