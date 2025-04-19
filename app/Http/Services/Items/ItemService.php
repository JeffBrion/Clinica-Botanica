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
            'code' => $request['code'],
        ]);

        return $item;
    }

    public static function updateItem( $request, Item $item)
    {
        
        $item->name = $request['name'];
        $item->description = $request['description'];
        $item->category_id = $request['category_id'];
        $item->code = $request['code'];
    
   
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