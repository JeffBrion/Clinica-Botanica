<?php
namespace App\Http\Services\Items;

use App\Models\Items\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public static function makeItem($request)
    {
        $item = Item::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'category_id' => $request['category_id'],
            'price' => $request['price'],
        ]);

        return $item;
    }

    public static function updateItem($item, $request)
    {
        $item->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'category_id' => $request['category_id'],
            'price' => $request['price'],
        ]);

        return $item;
    }

    public static function deleteItem($item)
    {
        $item->delete();
        return true;
    }
}