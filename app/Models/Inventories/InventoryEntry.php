<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Suppliers\SupplierProduct;
use App\Models\User;

class InventoryEntry extends Model
{
    protected $table = 'inventory_entries';

    protected $fillable = [
        'supplier_product_id',
        'quantity',
        'reason',
        'created_by',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
