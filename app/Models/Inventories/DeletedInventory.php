<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Suppliers\SupplierProduct;
use App\Models\User;
use Everth\UserStamps\UserStampsTrait;

class DeletedInventory extends Model
{
    Use UserStampsTrait;

    protected $table = 'deleted_inventories';

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
