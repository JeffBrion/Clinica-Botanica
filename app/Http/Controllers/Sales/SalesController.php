<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventories\Inventory;

class SalesController extends Controller
{
    //
    public function index()
    {
        $inventories = Inventory::all();   
        return view('sales.index' , compact('inventories'));
    }

}
