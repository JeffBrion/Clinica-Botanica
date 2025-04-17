<?php

namespace App\Http\Controllers\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Suppliers\Supplier;
use App\Http\Services\Suppliers\SupplierService;

class SuppliersController extends Controller
{
    public function index($pagination = 15){
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate($pagination);
        return view('suppliers.index', compact('suppliers'));
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function store()
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'promoter_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);
      
        $response = SupplierService::makeSupplier($request);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al crear el Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Proveedor creado correctamente',
            'type' => 'success',
        ]);
    }
    public function update(Supplier $supplier)
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'promoter_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        $response = SupplierService::updateSupplier($request, $supplier);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al actualizar el Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Proveedor actualizado correctamente',
            'type' => 'success',
        ]);
    }
    public function delete(Supplier $supplier)
    {
        $response = SupplierService::deleteSupplier($supplier);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al eliminar el Proveedor',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Proveedor eliminado correctamente',
            'type' => 'success',
        ]);
    }
}
