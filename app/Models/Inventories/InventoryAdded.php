<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Suppliers\SupplierProduct;
use App\Models\User;

use Everth\UserStamps\UserStampsTrait;

class InventoryAdded extends Model
{
    use UserStampsTrait;

    protected $table = 'inventory_added';

    protected $fillable = [
        'supplier_product_id',
        'quantity',
        'reason',

    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class);
    }

}
