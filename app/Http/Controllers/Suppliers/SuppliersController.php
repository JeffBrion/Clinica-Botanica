<?php

namespace App\Http\Controllers\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Suppliers\Supplier;
use App\Http\Services\Suppliers\SupplierService;
use App\Models\Items\Item;
use App\Models\Suppliers\SupplierProduct;

class SuppliersController extends Controller
{
    public function index($pagination = 6){
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate($pagination);
        return view('suppliers.index', compact('suppliers'));
    }

    public function show(Supplier $supplier, $pagination = 20)
    {

        $assignedItemIds = SupplierProduct::where('supplier_id', $supplier->id)->pluck('item_id')->toArray();

        $items = Item::whereNotIn('id', $assignedItemIds)
            ->orderBy('created_at', 'desc')
            ->paginate($pagination);

        return view('suppliers.show', compact('supplier', 'items'));

    }

    public function store(Request $request)
    {
        $requests = request()->validate([
            'name' => 'required|string|max:255',
            'promoter_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',

        ]);


        $response = SupplierService::makeSupplier($request);

        if ($response === null) {
            return redirect()->back()->with([
                'message' => 'Error al crear el Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Proveedor creado correctamente',
            'type' => 'success',
        ]);
    }

    public function assignItem(Request $request)
    {
        $request = request()->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'item_id' => 'required|exists:items,id',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
        ]);

        $response = SupplierService::assignItem($request);
        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al asignar el producto al Proveedor',
                'type' => 'danger',
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Producto asignado correctamente al Proveedor',
            'type' => 'success',
        ]);


    }

    public function showitems(Supplier $supplier, $pagination = 20)
    {
        $items = SupplierProduct::where('supplier_id', $supplier->id)
            ->with('item')
            ->orderBy('created_at', 'desc')
            ->paginate($pagination);
        return view('suppliers.showItems', compact('supplier', 'items'));
    }

    public function update(Supplier $supplier)
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'promoter_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Validación de imagen
        ]);

        $response = SupplierService::updateSupplier($request, $supplier);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al actualizar el Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Proveedor actualizado correctamente',
            'type' => 'success',
        ]);
    }
    public function delete(Supplier $supplier)
    {
        $response = SupplierService::deleteSupplier($supplier);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al eliminar el Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Proveedor eliminado correctamente',
            'type' => 'success',
        ]);
    }
    public function deleteItem(SupplierProduct $item)
    {
        $response = SupplierService::deleteItem($item);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al eliminar el producto del Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto eliminado correctamente del Proveedor',
            'type' => 'success',
        ]);
    }
}
