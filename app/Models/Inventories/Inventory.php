<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;

use Everth\UserStamps\UserStampsTrait;

use App\Models\Suppliers\SupplierProduct;

class Inventory extends Model
{
    use UserStampsTrait;

    protected $fillable = [
        'supplier_product_id',
        'quantity',
        'requested_date',
        'expiration_date',
        'status',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class);
    }
}
