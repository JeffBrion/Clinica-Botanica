
<div class="table-responsive d-none d-md-block">
    <table class="table table-hover align-middle">
        <thead class="table-light sticky-top">
            <tr>
                <th style="width: 120px;">Código</th>
                <th>Producto</th>
                <th class="text-end" style="width: 140px;">Cantidad</th>
                <th style="width: 140px;">Vence</th>
                <th class="text-end" style="width: 140px;">Días</th>
                <th style="width: 160px;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($expiring ?? collect()) as $row)
                @php
                    $urgent = (int) $row['days_left'] <= 7;
                @endphp
                <tr>
                    <td><span class="code-pill">{{ $row['code'] ?? '—' }}</span></td>
                    <td class="fw-medium">{{ $row['name'] }}</td>
                    <td class="text-end fw-semibold">{{ $row['quantity'] }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($row['expires_at'])->format('Y-m-d') }}</td>
                    <td class="text-end">{{ number_format($row['days_left'], 2) }}</td>
                    <td>
                        @if($urgent)
                            <span class="status-badge danger"><i class='bx bx-error-circle me-1'></i>Urgente</span>
                        @else
                            <span class="status-badge warning"><i class='bx bx-time-five me-1'></i>Próximo</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <div class="empty-state">
                            <i class='bx bx-time'></i>
                            <div class="mt-2">No hay productos próximos a vencer.</div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Lista en móvil: vencimientos -->
<div class="d-md-none">
    @forelse(($expiring ?? collect()) as $row)
        @php $urgent = (int) $row['days_left'] <= 7; @endphp
        <div class="card mb-2 border-0 shadow-xs">
            <div class="card-body d-flex justify-content-between align-items-center gap-2">
                <div>
                    <div class="fw-semibold">{{ $row['name'] }}</div>
                    <div class="text-muted small">Código: <span class="text-monospace">{{ $row['code'] ?? '—' }}</span></div>
                    <div class="text-muted small">Vence: {{ \Illuminate\Support\Carbon::parse($row['expires_at'])->format('Y-m-d') }}</div>
                </div>
                <div class="text-end">
                    <div class="fw-bold">{{ $row['quantity'] }}</div>
                    <div class="text-muted small">Días: {{ number_format($row['days_left'], 2) }}</div>
                    <div class="mt-1">
                        @if($urgent)
                            <span class="status-badge danger"><i class='bx bx-error-circle me-1'></i>Urgente</span>
                        @else
                            <span class="status-badge warning"><i class='bx bx-time-five me-1'></i>Próximo</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            <div class="empty-state">
                <i class='bx bx-time'></i>
                <div class="mt-2">No hay productos próximos a vencer.</div>
            </div>
        </div>
    @endforelse
</div>
