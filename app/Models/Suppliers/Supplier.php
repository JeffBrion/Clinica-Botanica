<?php

namespace App\Models\Suppliers;

use Illuminate\Database\Eloquent\Model;
use Everth\UserStamps\UserStampsTrait;


use App\Models\Suppliers\SupplierProduct;

class Supplier extends Model
{
    use UserStampsTrait;

    protected $fillable = [
        'name',
        'promoter_name',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'image_path',
    ];

    public function products()
    {
        return $this->belongsToMany(Item::class, 'supplier_products');
    }


}
