<?php
namespace App\Http\Services\Inventories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Inventories\Inventory;

class InventoryService
{
    public static function makeInventory($request)
    {
        $user = Auth::user();

        // Copiar los productos del request para evitar modificar directamente el objeto Request
        $products = $request->products;

        foreach ($products as &$product) {
            if (empty($product['expiration_date'])) {
                $product['expiration_date'] = now()->addYear();
            }
        }

        $userId = Auth::check() ? Auth::id() : null;

        foreach ($products as $product) {
            $supplierProductId = $product['supplier_product_id'];

            Inventory::create([
                'supplier_product_id' => $supplierProductId,
                'quantity' => $product['quantity'],
                'requested_date' => now(),
                'expiration_date' => $product['expiration_date'] ?? null,
                'status' => 'Entrada',
                'created_by' => $userId,
                'updated_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return true;
    }


 
}
