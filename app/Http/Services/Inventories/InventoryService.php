<?php
namespace App\Http\Services\Inventories;


use Illuminate\Support\Facades\Auth;

use App\Models\Inventories\Inventory;

class InventoryService
{
    public static function makeInventory($request)
    {
        $user = Auth::user();
        $inventories = [];

        foreach ($request->products as $product) {
            $existingInventory = Inventory::where('supplier_product_id', $product['id'])->first();

            if ($existingInventory) {
       
            $existingInventory->quantity += $product['quantity'];
            $existingInventory->save();
            } else {

            $inventories[] = [
                'supplier_product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'requested_date' => now(),
                'expiration_date' => $product['expiration_date'],
                'status' => '1',
                'created_by' => $user->id,
            ];
            }
        }

        return Inventory::insert($inventories);
    }
}