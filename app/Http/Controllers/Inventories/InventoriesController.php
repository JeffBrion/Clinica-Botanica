<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventories\Inventory;
use App\Models\Suppliers\Supplier;
use App\Models\Suppliers\SupplierProduct;

class InventoriesController extends Controller
{
    public function index()
    {
      
        return view('inventories.index');
    }
    public function entries()
    {
        $suppliers = Supplier::all();
        return view('entries.index', compact('suppliers'));
    }
}
