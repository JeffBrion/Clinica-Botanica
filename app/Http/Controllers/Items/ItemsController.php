<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Http\Services\Items\ItemService;
use App\Models\Items\Item;
use App\Models\Categories\Category;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index($pagination = 15){
        $categories = Category::orderBy('created_at', 'desc')->paginate($pagination);
        $items = Item::orderBy('created_at', 'desc')->paginate($pagination);
        return view('items.index', compact('categories', 'items'));
    }

    public function show(Item $item)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('items.show', compact('item', 'categories'));
    }

    public function store()
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:255',
        ]);

        $response = ItemService::makeItem($request);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al crear el Producto',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto creado correctamente',
            'type' => 'success',
        ]);
    }

    public function update(Item $item)
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $response = ItemService::updateItem( $request, $item);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al actualizar el Producto',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto actualizado correctamente',
            'type' => 'success',
        ]);
    }
    public function delete(Item $item)
    {
        $response = ItemService::deleteItem($item);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al eliminar el Producto',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Producto eliminado correctamente',
            'type' => 'success',
        ]);
    }
}