<!-- Componente: Alertas de Stock -->
<!-- Tabla en desktop -->
<div class="table-responsive d-none d-md-block">
    <table class="table table-hover align-middle">
        <thead class="table-light sticky-top">
            <tr>
                <th style="width: 120px;">Código</th>
                <th>Producto</th>
                <th class="text-end" style="width: 140px;">Stock</th>
                <th class="text-end" style="width: 120px;">Umbral</th>
                <th style="width: 140px;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alerts as $row)
                @php
                    $isZero = (int) $row['stock'] === 0;
                    $isLow = (int) $row['stock'] <= (int) $threshold;
                @endphp
                <tr>
                    <td><span class="code-pill">{{ $row['code'] ?? '—' }}</span></td>
                    <td class="fw-medium">{{ $row['name'] }}</td>
                    <td class="text-end fw-semibold">{{ $row['stock'] }}</td>
                    <td class="text-end">{{ $threshold }}</td>
                    <td>
                        @if($isZero)
                            <span class="status-badge danger"><i class='bx bx-x-circle me-1'></i>Agotado</span>
                        @elseif($isLow)
                            <span class="status-badge warning"><i class='bx bx-error me-1'></i>Bajo</span>
                        @else
                            <span class="status-badge success"><i class='bx bx-check-circle me-1'></i>Ok</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <div class="empty-state">
                            <i class='bx bx-package'></i>
                            <div class="mt-2">No hay alertas con el umbral seleccionado.</div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Lista en móvil -->
<div class="d-md-none">
    @forelse($alerts as $row)
        @php
            $isZero = (int) $row['stock'] === 0;
            $isLow = (int) $row['stock'] <= (int) $threshold;
        @endphp
        <div class="card mb-2 border-0 shadow-xs">
            <div class="card-body d-flex justify-content-between align-items-center gap-2">
                <div>
                    <div class="fw-semibold">{{ $row['name'] }}</div>
                    <div class="text-muted small">Código: <span class="text-monospace">{{ $row['code'] ?? '—' }}</span></div>
                </div>
                <div class="text-end">
                    <div class="fw-bold">{{ $row['stock'] }}</div>
                    <div class="text-muted small">Umbral {{ $threshold }}</div>
                    <div class="mt-1">
                        @if($isZero)
                            <span class="status-badge danger"><i class='bx bx-x-circle me-1'></i>Agotado</span>
                        @elseif($isLow)
                            <span class="status-badge warning"><i class='bx bx-error me-1'></i>Bajo</span>
                        @else
                            <span class="status-badge success"><i class='bx bx-check-circle me-1'></i>Ok</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            <div class="empty-state">
                <i class='bx bx-package'></i>
                <div class="mt-2">No hay alertas con el umbral seleccionado.</div>
            </div>
        </div>
    @endforelse
</div>
