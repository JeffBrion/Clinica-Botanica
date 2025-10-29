<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventories\Inventory;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class StockAlertsController extends Controller
{
    /**
     * Lista de alertas de bajo stock por ítem
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $threshold = (int) ($request->get('threshold') ?? env('LOW_STOCK_THRESHOLD', 10));
        if ($threshold < 0) { $threshold = 0; }
        $expDays = (int) ($request->get('days') ?? 30);
        if ($expDays < 1) { $expDays = 30; }

        // Cargar inventarios en estado Entrada y sumar stock por Item
        $inventories = Inventory::query()
            ->with(['supplierProduct.item'])
            ->where('status', 'Entrada')
            ->get();

        $totals = [];
        $meta = [];
        foreach ($inventories as $inv) {
            $item = optional($inv->supplierProduct)->item;
            if (!$item) continue;
            $itemId = (int) $item->id;
            $totals[$itemId] = ($totals[$itemId] ?? 0) + (int) $inv->quantity;
            if (!isset($meta[$itemId])) {
                $meta[$itemId] = [
                    'name' => $item->name,
                    'code' => $item->code,
                ];
            }
        }

        // Construir colección de items con stock <= umbral
        $alerts = collect($totals)
            ->map(function ($stock, $itemId) use ($meta) {
                return [
                    'id' => (int) $itemId,
                    'name' => $meta[$itemId]['name'] ?? 'Desconocido',
                    'code' => $meta[$itemId]['code'] ?? null,
                    'stock' => (int) $stock,
                ];
            })
            ->filter(function ($row) use ($threshold) {
                return $row['stock'] <= $threshold; // en o por debajo del umbral
            })
            ->when($q, function ($col) use ($q) {
                $qq = mb_strtolower($q);
                return $col->filter(function ($row) use ($qq) {
                    return str_contains(mb_strtolower($row['name']), $qq)
                        || str_contains(mb_strtolower((string) ($row['code'] ?? '')), $qq);
                });
            })
            ->sortBy('stock')
            ->values();

        // Construir alertas de vencimiento (<= $expDays días)
        $now = Carbon::now()->startOfDay();
        $limit = (clone $now)->addDays($expDays);

        $expiringGrouped = [];
        foreach ($inventories as $inv) {
            $item = optional($inv->supplierProduct)->item;
            if (!$item) continue;

            // Excluir sin fecha o ya vencidos
            if (empty($inv->expiration_date)) continue;
            $exp = Carbon::parse($inv->expiration_date)->endOfDay();
            if ($exp->lt($now) || $exp->gt($limit)) continue;

            $itemId = (int) $item->id;
            if (!isset($expiringGrouped[$itemId])) {
                $expiringGrouped[$itemId] = [
                    'id' => $itemId,
                    'name' => $item->name,
                    'code' => $item->code,
                    'quantity' => 0,
                    'nearest_expiration' => $exp,
                ];
            }
            $expiringGrouped[$itemId]['quantity'] += (int) $inv->quantity;
            if ($exp->lt($expiringGrouped[$itemId]['nearest_expiration'])) {
                $expiringGrouped[$itemId]['nearest_expiration'] = $exp;
            }
        }

        $expiring = collect($expiringGrouped)
            ->map(function ($row) use ($now) {
                $days = $now->diffInDays($row['nearest_expiration'], false);
                return [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'code' => $row['code'],
                    'quantity' => $row['quantity'],
                    'expires_at' => $row['nearest_expiration']->toDateString(),
                    'days_left' => $days,
                ];
            })
            ->when($q, function ($col) use ($q) {
                $qq = mb_strtolower($q);
                return $col->filter(function ($row) use ($qq) {
                    return str_contains(mb_strtolower($row['name']), $qq)
                        || str_contains(mb_strtolower((string) ($row['code'] ?? '')), $qq);
                });
            })
            ->sortBy('days_left')
            ->values();

        return view('inventories.alerts', [
            'alerts' => $alerts,
            'threshold' => $threshold,
            'q' => $q,
            'expiring' => $expiring,
            'expDays' => $expDays,
        ]);
    }
}
