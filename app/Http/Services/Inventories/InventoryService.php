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
        
            if ($existingInventory && $existingInventory->status !== 'Eliminado') {
                $existingInventory->quantity += $product['quantity'];
                $existingInventory->updated_by = $user->id;
                $existingInventory->updated_at = now();
                $existingInventory->save();
            } else {
                // Always create a new inventory record with the correct created_by user
                $inventories[] = [
                    'supplier_product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'requested_date' => now(),
                    'expiration_date' => $product['expiration_date'] ?? null,
                    'status' => 'Entrada',
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];
            }
        }

        if (!empty($inventories)) {
            Inventory::insert($inventories);
        }

        return true;
    }


    public static function historydelete($inventory)
    {

        $inventoryId = is_array($inventory) ? ($inventory['inventory_id'] ?? null) : ($inventory->id ?? $inventory);
        $quantity = is_array($inventory) ? ($inventory['quantity'] ?? 0) : ($inventory->quantity ?? 0);
        $deletedBy = is_array($inventory) ? ($inventory['deleted_by'] ?? auth()->id()) : ($inventory->deleted_by ?? auth()->id());

        $existingInventory = Inventory::find($inventoryId);

        if (!$existingInventory) {
            return false;
        }

            if ($existingInventory->quantity == $quantity) {
                $existingInventory->status = 'Eliminado';
                $existingInventory->created_by = $deletedBy;
                $existingInventory->requested_date = now();
                $existingInventory->save();

            } elseif ($existingInventory->quantity > 0 ) {

            $existingInventory->quantity -= $quantity;
            $existingInventory->save();
            $deletedInventory = $existingInventory->replicate();
            $deletedInventory->quantity = $quantity;
            $deletedInventory->status = 'Eliminado';
            $deletedInventory->created_by = $deletedBy;
            $deletedInventory->requested_date = now();
            $deletedInventory->save();

            } else {
                return false;
            }
            return true;


    }
}
