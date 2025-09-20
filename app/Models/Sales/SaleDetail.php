<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
         'inventory_id',
        'quantity',
        'price',
    ];

    /**
     * Get the sale that owns the detail.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
