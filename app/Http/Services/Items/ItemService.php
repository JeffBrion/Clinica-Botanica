<?php
namespace App\Http\Services\Items;

use App\Models\Items\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public static function makeItem($request)
    {
        // if (Item::where('name', $request['name'])
        //     ->where('description', $request['description'])
        //     ->exists()) {
        //     return null;
        // }
        $item = Item::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'category_id' => $request['category_id'],

        ]);

        $nameInitials = strtoupper(substr(preg_replace('/\s+/', '', $request['name']), 0, 3));
        $randomNumbers = str_pad(mt_rand(0, 19999), 4, '0', STR_PAD_LEFT);
        $item->code = $nameInitials . $randomNumbers;
        $item->save();
        return $item;
    }

    public static function updateItem( $request, Item $item)
    {

        $item->name = $request['name'];
        $item->description = $request['description'];
        $item->category_id = $request['category_id'];


        if ($item->save()) {
            return $item;
        }

        return null;

    }

    public static function deleteItem($item)
    {
        $item->delete();
        return true;
    }
}
