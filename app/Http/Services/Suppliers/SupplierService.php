<?php
namespace App\Http\Services\Suppliers;

use App\Models\Suppliers\Supplier;
use App\Models\Items\Item;
use App\Models\Suppliers\SupplierProduct;

use Illuminate\Support\Facades\Auth;

class SupplierService
{
    public static function makeSupplier($request)
    {
        if (!$request instanceof \Illuminate\Http\Request) {
            throw new \InvalidArgumentException('La solictud debe ser una instancia adecuada.');
        }
    
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('suppliers', 'public'); 
        }
    
        $supplier = Supplier::create([
            'name' => $request['name'],
            'promoter_name' => $request['promoter_name'],
            'description' => $request['description'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'website' => $request['website'],
            'image_path' => $imagePath,
        ]);

        return $supplier;
    }

    public static function updateSupplier($request, Supplier $supplier)
    {
        $supplier->name = $request['name'];
        $supplier->promoter_name = $request['promoter_name'];
        $supplier->description = $request['description'];
        $supplier->address = $request['address'];
        $supplier->phone = $request['phone'];
        $supplier->email = $request['email'];
        $supplier->website = $request['website'];
    
        if ($supplier->save()) {
            return $supplier;
        }
    
        return null;
    }
    
    public static function deleteSupplier($supplier)
    {
        $supplier->delete();
        return true;
    }

    public static function assignItem($request)
    {
        // Verificar si ya existe la relación entre supplier_id e item_id
        $exists = SupplierProduct::where('supplier_id', $request['supplier_id'])
            ->where('item_id', $request['item_id'])
            ->exists();

        if ($exists) {
            return null;
        }

        $supplierproduct = SupplierProduct::create([
            'supplier_id' => $request['supplier_id'],
            'item_id' => $request['item_id'],
            'buy_price' => $request['buy_price'],
            'sell_price' => $request['sell_price'],
        ]);

        return $supplierproduct;
    }

    public static function deleteItem($itemassigned)
    {
        $itemassigned->delete();
        return true;
    }
}