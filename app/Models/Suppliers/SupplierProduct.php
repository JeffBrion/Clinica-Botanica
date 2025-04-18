<?php

namespace App\Models\Suppliers;

use Illuminate\Database\Eloquent\Model;

use Everth\UserStamps\UserStampsTrait;

use App\Models\Items\Item;
use App\Models\Suppliers\Supplier;

class SupplierProduct extends Model
{
    use UserStampsTrait;

    protected $fillable = [
        'supplier_id',
        'item_id',
        'buy_price',
        'sell_price',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
