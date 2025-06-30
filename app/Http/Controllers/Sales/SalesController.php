<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventories\Inventory;

class SalesController extends Controller
{
    //
    public function index( $pagination = 15)
    {
        $inventories = Inventory::where('status', 'Entrada')
            ->orderBy('created_at', 'desc')
            ->paginate($pagination);
        return view('sales.index', compact('inventories'));
    }

}
