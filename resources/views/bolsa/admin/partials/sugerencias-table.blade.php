<div class="space-y-4">
    @forelse ($empleados as $empleado)
        @php
            $subareasList = collect([$empleado->primaryArea, $empleado->secondaryArea, $empleado->tertiaryArea])->filter();
            $subareaLabels = $subareasList->pluck('nombre_subarea')->filter();
            $suggestionLabel = trim($empleado->sugerencia ?? '') ?: 'Sin sugerencia';
            $subareaIds = $subareasList->pluck('id_subarea')->filter()->values()->all();
            $reassignPayload = [
                'id' => $empleado->id_empleado,
                'subareas' => $subareaIds,
                'updateUrl' => route('bolsa.empleados.reassign', $empleado),
            ];
        @endphp
        <article class="flex flex-col gap-4 rounded-3xl border border-slate-500 bg-white px-6 py-5 shadow-[0_20px_70px_-25px_rgba(15,23,42,0.6)] md:flex-row md:items-center md:justify-between">
            <div class="space-y-3">
                <div class="space-y-1">
                    <p class="text-lg font-semibold text-slate-900">{{ $empleado->nombre_completo }}</p>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Subáreas</p>
                </div>
                @if ($subareaLabels->isNotEmpty())
                    <ul class="flex flex-wrap gap-2">
                        @foreach ($subareaLabels as $label)
                            <li class="rounded-full border border-slate-300 bg-slate-100 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-slate-900">
                                {{ $label }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-slate-500 italic">Sin subáreas asignadas</p>
                @endif
                <p class="text-sm text-slate-600">
                    <span class="text-[0.65rem] uppercase tracking-[0.3em] text-slate-500">Sugerencia:</span>
                    {{ $suggestionLabel }}
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @if ($empleado->ruta_curriculum)
                    <a
                        href="{{ route('bolsa.curriculum.preview', $empleado) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-full border border-slate-500 bg-white px-4 py-2 text-[0.65rem] font-semibold text-slate-900 transition hover:border-slate-400 hover:bg-slate-100"
                    >
                        Previsualizar
                    </a>
                    <a
                        href="{{ route('bolsa.curriculum.download', $empleado) }}"
                        class="rounded-full border border-emerald-400 bg-emerald-50 px-4 py-2 text-[0.65rem] font-semibold text-emerald-800 transition hover:border-emerald-500 hover:bg-emerald-100"
                    >
                        Descargar
                    </a>
                @else
                    <span class="rounded-full border border-slate-300 px-3 py-2 text-[0.6rem] font-semibold tracking-[0.3em] text-slate-500">
                        Sin currículum
                    </span>
                @endif
                <button
                    type="button"
                    data-reassign-employee='@json($reassignPayload, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE)'
                    class="ml-auto flex h-10 items-center gap-2 rounded-full border border-red-500 bg-red-600 px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-white shadow-lg transition hover:bg-red-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-red-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M2 12.5A5.5 5.5 0 017.5 7h2.25a.75.75 0 000-1.5H7.5A7 7 0 103.21 15.08l1.06-1.06A5.5 5.5 0 012 12.5zm9.22-6.78l4.09 4.09a.75.75 0 010 1.06l-4.09 4.09a.75.75 0 01-1.06-1.06l2.06-2.03H6.5a.75.75 0 010-1.5h5.72L10.16 6.78a.75.75 0 011.06-1.06z"/>
                    </svg>
                    Reasignar
                </button>
            </div>
        </article>
    @empty
        <div class="rounded-3xl border border-slate-500 bg-white/90 p-6 text-center text-sm text-slate-500">
            No hay sugerencias por el momento.
        </div>
    @endforelse
</div>
