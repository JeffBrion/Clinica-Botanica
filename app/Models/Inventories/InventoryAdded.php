<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Suppliers\SupplierProduct;
use App\Models\User;

class InventoryAdded extends Model
{
    protected $table = 'inventory_added';

    protected $fillable = [
        'supplier_product_id',
        'quantity',
        'reason',
        'added_by',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
