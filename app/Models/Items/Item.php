<?php

namespace App\Models\Items;

use App\Models\Categories\Category;
use App\Models\Suppliers\Supplier;
use App\Models\Suppliers\SupplierProduct;

use Illuminate\Database\Eloquent\Model;

use Everth\UserStamps\UserStampsTrait;


class Item extends Model
{
    use UserStampsTrait;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'code',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_products');
    }
    public function suppliersProducts()
    {
        return $this->hasMany(SupplierProduct::class);
    }
}
