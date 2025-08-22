<?php
namespace App\Http\Services\Inventories;


use Illuminate\Support\Facades\Auth;

use App\Models\Inventories\Inventory;

class InventoryService
{
    public static function makeInventory($request)
    {
        $user = Auth::user();

        foreach ($request->products as $product) {
            $supplierProductId = $product['supplier_product_id'];

            $existing = Inventory::where('supplier_product_id', $supplierProductId)
                ->where('status', 'Entrada')
                ->first();

            if ($existing) {
                $existing->quantity += $product['quantity'];
                $existing->expiration_date = $product['expiration_date'] ?? $existing->expiration_date;
                $existing->updated_by = $user->id;
                $existing->updated_at = now();
                $existing->save();
            } else {
                $deleted = Inventory::where('supplier_product_id', $supplierProductId)
                    ->where('status', 'Eliminado')
                    ->first();

                if ($deleted) {
                    $newInventory = $deleted->replicate();
                    $newInventory->quantity = $product['quantity'];
                    $newInventory->requested_date = now();
                    $newInventory->expiration_date = $product['expiration_date'] ?? $deleted->expiration_date;
                    $newInventory->status = 'Entrada';
                    $newInventory->created_by = $user->id;
                    $newInventory->updated_by = $user->id;
                    $newInventory->created_at = now();
                    $newInventory->updated_at = now();
                    $newInventory->supplier_product_id = $supplierProductId; // asegúrate de esto
                    $newInventory->save();
                } else {
                    Inventory::create([
                        'supplier_product_id' => $supplierProductId,
                        'quantity' => $product['quantity'],
                        'requested_date' => now(),
                        'expiration_date' => $product['expiration_date'] ?? null,
                        'status' => 'Entrada',
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return true;
    }


    public static function historydelete($inventory)
    {
        $reason = is_array($inventory) ? ($inventory['reason'] ?? null) : ($inventory->reason ?? null);
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
                $existingInventory->observation = $reason;

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
            $deletedInventory->observation = $reason;
            $deletedInventory->save();

            } else {
                return false;
            }
            return true;


    }
}
