<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Suppliers\SupplierProduct;
use App\Models\User;

class DeletedInventory extends Model
{
    protected $table = 'deleted_inventories';

    protected $fillable = [
        'supplier_product_id',
        'quantity',
        'reason',
        'deleted_by',
        'deleted_at',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
