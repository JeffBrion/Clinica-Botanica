<?php

namespace App\Models\Items;

use App\Models\Categories\Category;
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
}
