<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reports\Report;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function index($pagination = 25)
    {
        $reports= Report::orderBy('created_at', 'desc')->paginate($pagination);
        return view('reports.index', compact('reports'));
    }
    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'report_type' => 'required|string|in:sales,supplier_income,inventory_movements',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $reportType = $request->input('report_type');

        // Create a new report entry in the database
        $report = new \App\Models\Reports\Report();

        if ($reportType === 'sales') {
             $report->report_type = 'Ventas';
        } elseif ($reportType === 'supplier_income') {
            $report->report_type = 'Ingresos por Proveedor';
        } elseif ($reportType === 'inventory_movements') {
            $report->report_type = 'Movimientos de Inventario';
        }
        $report->start_date = $startDate;
        $report->end_date = $endDate;
        $report->create_date = now();
    $report->created_by = Auth::id();
        $report->save();

        return back()->with('success', 'Reporte creado exitosamente.');
    }

    public function show(Report $report)
    {

        $datas = [];
        if ($report->report_type === 'Ventas') {
            $datas = \App\Models\Sales\Sale::with('user')
                ->whereBetween('sale_date', [$report->start_date, $report->end_date])
                ->get()
                ->map(function ($row) use ($report) {
                    $row->report_type = $report->report_type; // Anexar tipo al item
                    return $row;
                });
        } elseif ($report->report_type === 'Ingresos por Proveedor') {
            // Mostrar cada ingreso desde inventory_added con detalles del proveedor y del producto (item)
            $datas = DB::table('inventory_added')
                ->join('supplier_products', 'inventory_added.supplier_product_id', '=', 'supplier_products.id')
                ->leftJoin('items', 'supplier_products.item_id', '=', 'items.id')
                ->leftJoin('suppliers', 'supplier_products.supplier_id', '=', 'suppliers.id')
                ->leftJoin('users', 'inventory_added.created_by', '=', 'users.id')
                ->whereBetween('inventory_added.created_at', [$report->start_date, $report->end_date])
                ->select(
                    'inventory_added.id',
                    'inventory_added.quantity',
                    'inventory_added.reason',
                    'inventory_added.created_at',
                    DB::raw('COALESCE(items.name, "") as item_name'),
                    DB::raw('COALESCE(suppliers.name, "") as supplier_name'),
                    DB::raw('COALESCE(users.name, "") as user_name')
                )
                ->orderBy('inventory_added.created_at', 'desc')
                ->get()
                ->map(function ($row) use ($report) {
                    $row->report_type = $report->report_type; // Anexar tipo al item
                    return $row;
                });
        } elseif ($report->report_type === 'Movimientos de Inventario') {
            // Solo mostrar movimientos eliminados desde deleted_inventories
            $datas = DB::table('deleted_inventories')
                ->join('supplier_products', 'deleted_inventories.supplier_product_id', '=', 'supplier_products.id')
                ->leftJoin('items', 'supplier_products.item_id', '=', 'items.id')
                ->leftJoin('suppliers', 'supplier_products.supplier_id', '=', 'suppliers.id')
                ->whereBetween('deleted_inventories.created_at', [$report->start_date, $report->end_date])
                ->select(
                    'deleted_inventories.id',
                    'deleted_inventories.supplier_product_id',
                    'deleted_inventories.quantity',
                    'deleted_inventories.reason',
                    'deleted_inventories.created_at',
                    DB::raw('COALESCE(items.name, "") as item_name'),
                    DB::raw('COALESCE(suppliers.name, "") as supplier_name')
                )
                ->get()
                ->map(function ($row) use ($report) {
                    $row->report_type = $report->report_type; // Anexar tipo al item
                    return $row;
                });
        }



        return view('reports.show', compact('report', 'datas'));
    }
}
