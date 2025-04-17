<?php
namespace App\Http\Services\Suppliers;

use App\Models\Suppliers\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierService
{
    public static function makeSupplier($request)
    {
   
        $supplier = Supplier::create([
            'name' => $request['name'],
            'promoter_name' => $request['promoter_name'],
            'description' => $request['description'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'website' => $request['website'],
        ]);

        return $supplier;
    }

    public static function updateSupplier($request, Supplier $supplier)
    {
        $supplier->name = $request['name'];
        $supplier->promoter_name = $request['promoter_name'];
        $supplier->description = $request['description'];
        $supplier->address = $request['address'];
        $supplier->phone = $request['phone'];
        $supplier->email = $request['email'];
        $supplier->website = $request['website'];
    
        if ($supplier->save()) {
            return $supplier;
        }
    
        return null;
    }
    
    public static function deleteSupplier($supplier)
    {
        $supplier->delete();
        return true;
    }
}