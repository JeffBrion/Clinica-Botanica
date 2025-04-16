<?php

namespace App\Models\Categories;

use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Model;
use Everth\UserStamps\UserStampsTrait;
class Category extends Model
{
    use UserStampsTrait;
    protected $fillable = [
        'name',
        'description',
    ];
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
