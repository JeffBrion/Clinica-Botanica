<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Everth\UserStamps\UserStampsTrait;

class Sale extends Model
{
    use UserStampsTrait;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_date',
        'client_name',
        'total_amount',
        'created_by',
    ];

    /**
     * Get the details for the sale.
     */
    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
