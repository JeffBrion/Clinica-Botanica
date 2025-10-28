<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Consultations\Consultation;
use App\Models\Consultations\ConsultationMedication;
use App\Models\Items\Item;
use App\Models\Inventories\Inventory;

class TestController extends Controller
{
    //
    public function index()
    {
        // Solo manda inventories en estado Entrada (sin joins manuales)
        $inventories = Inventory::query()
            ->with(['supplierProduct.item'])
            ->where('status', 'Entrada')
            ->orderBy('created_at', 'desc')
            ->get();

        // Sumar stock por item a partir de inventories
        $totals = [];
        $itemsMeta = [];
        foreach ($inventories as $inv) {
            $item = optional($inv->supplierProduct)->item;
            if (!$item) continue;
            $itemId = (int) $item->id;
            $totals[$itemId] = ($totals[$itemId] ?? 0) + (int) $inv->quantity;
            if (!isset($itemsMeta[$itemId])) {
                $itemsMeta[$itemId] = [
                    'name' => $item->name,
                    'code' => $item->code,
                ];
            }
        }

        // Construimos la lista de medicamentos a partir de los totales (> 0)
        $medicationItems = collect($totals)
            ->filter(fn($stock) => $stock > 0)
            ->map(function ($stock, $itemId) use ($itemsMeta) {
                return [
                    'id' => (int) $itemId,
                    'name' => $itemsMeta[$itemId]['name'] ?? 'Desconocido',
                    'code' => $itemsMeta[$itemId]['code'] ?? null,
                    'stock' => (int) $stock,
                ];
            })
            ->values()
            ->sortBy('name')
            ->values()
            ->all();

        return view('tests.index', [
            'inventories' => $inventories,
            'medicationItems' => $medicationItems,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'consultation_date' => 'required|date',
            'consultation_type' => 'required|string|in:primera_vez,control,emergencia,seguimiento',
            'symptoms' => 'required|string',
            'is_chronic' => 'nullable|boolean',
            'weight' => 'nullable|numeric|min:0|max:1000',
            'blood_pressure' => 'nullable|string|max:20',
            'heart_rate' => 'nullable|integer|min:0|max:300',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medications' => 'nullable|array',
            'medications.*.product_id' => 'nullable|integer',
            'medications.*.quantity' => 'nullable|integer|min:1',
            'medications.*.instructions' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $consultation = Consultation::create([
                'patient_name' => $data['patient_name'],
                'consultation_date' => $data['consultation_date'],
                'consultation_type' => $data['consultation_type'],
                'symptoms' => $data['symptoms'],
                'is_chronic' => (bool) ($data['is_chronic'] ?? false),
                'weight' => $data['weight'] ?? null,
                'blood_pressure' => $data['blood_pressure'] ?? null,
                'heart_rate' => $data['heart_rate'] ?? null,
                'diagnosis' => $data['diagnosis'] ?? null,
                'treatment' => $data['treatment'] ?? null,
            ]);

            if (!empty($data['medications']) && is_array($data['medications'])) {
                foreach ($data['medications'] as $med) {
                    $itemId = $med['product_id'] ?? null;
                    $qty = $med['quantity'] ?? null;
                    if (!$itemId || !$qty) continue;
                    ConsultationMedication::create([
                        'consultation_id' => $consultation->id,
                        'item_id' => $itemId,
                        'quantity' => $qty,
                        'instructions' => $med['instructions'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('test.index')->with('success', 'Consulta guardada correctamente.');
    }

    public function show(Request $request)
    {
        $q = $request->string('q')->toString();

        $consultations = Consultation::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('patient_name', 'like', "%$q%")
                       ->orWhere('consultation_type', 'like', "%$q%")
                       ->orWhere('symptoms', 'like', "%$q%");
                });
            })
            ->withCount('medications')
            ->orderByDesc('consultation_date')
            ->paginate(15)
            ->withQueryString();

        return view('tests.show', compact('consultations', 'q'));
    }

    public function prescription(Consultation $consultation)
    {
        $consultation->load(['medications.item', 'createdBy']);
        return view('tests.prescription', compact('consultation'));
    }
}
