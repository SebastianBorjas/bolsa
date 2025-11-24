<div class="grid gap-4 lg:grid-cols-2 items-stretch auto-rows-fr">
    @forelse ($empleados as $empleado)
        @php
            $editData = [
                'id' => $empleado->id_empleado,
                'nombre_completo' => $empleado->nombre_completo,
                'celular' => $empleado->celular,
                'correo' => $empleado->correo,
                'edad' => $empleado->edad,
                'estudios' => $empleado->estudios,
                'experiencia' => $empleado->experiencia,
                'dispuesto' => $empleado->dispuesto,
                'sugerencia' => $empleado->sugerencia ?? '',
                'subareas' => collect([$empleado->area1, $empleado->area2, $empleado->area3])->filter()->values()->all(),
            ];
        @endphp
        <article class="flex h-full min-h-[16rem] flex-col justify-between rounded-3xl border border-slate-500 bg-white/90 px-6 py-6 shadow-lg shadow-black/10 text-slate-900">
            <div class="grid gap-4 md:grid-cols-[2fr_1fr_1fr]">
                <div class="space-y-1">
                    <p class="text-lg font-semibold text-slate-900">{{ $empleado->nombre_completo }}</p>
                    <p class="text-sm text-slate-600">{{ $empleado->correo }}</p>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Edad {{ $empleado->edad }}</p>
                </div>

                <div class="space-y-2">
                    <p class="text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-slate-500">Subareas</p>
                    <ul class="list-disc space-y-1 pl-5 text-sm text-slate-700">
                        @php
                            $subareasList = collect([$empleado->primaryArea, $empleado->secondaryArea, $empleado->tertiaryArea])->filter();
                            $areaNotes = $subareasList->map(fn ($subarea) => optional($subarea->area)->nombre_area)
                                ->filter()
                                ->unique()
                                ->values();
                        @endphp
                        @foreach ($subareasList as $subarea)
                            <li>{{ $subarea->nombre_subarea }}</li>
                        @endforeach
                    </ul>
                </div>

            <div class="space-y-2">
                <p class="text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-slate-500">Experiencia</p>
                <p class="text-sm text-slate-700">{{ $empleado->experiencia }}</p>
                <p class="text-sm text-slate-500">Dispuesto a viajar: <span class="font-semibold text-slate-900">{{ ucfirst($empleado->dispuesto) }}</span></p>
            </div>
            </div>
            <div class="mt-5 flex flex-col gap-3">
                <div class="text-[0.65rem] text-slate-500">
                    <p>Areas relacionadas: {{ $areaNotes->count() ? $areaNotes->join(', ') : 'No disponible' }}</p>
                    <p>Registrado el {{ optional($empleado->fecha_registro)->format('d/m/Y') }}</p>
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
                        <span class="rounded-full border border-slate-500 px-3 py-2 text-[0.6rem] font-semibold tracking-[0.3em] text-slate-500">
                            Sin curriculum
                        </span>
                    @endif
                    <button
                        type="button"
                        data-edit-employee-button
                        data-employee='@json($editData, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE)'
                        class="ml-auto flex items-center gap-2 rounded-full border border-red-500 bg-red-600 px-3 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-white shadow-lg transition hover:bg-red-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-red-300"
                        aria-label="Editar datos de {{ $empleado->nombre_completo }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0l-1.037 1.037 2.828 2.828 1.037-1.037a2 2 0 000-2.828z"></path>
                            <path
                                fill-rule="evenodd"
                                d="M3 13.25V17h3.75l9.6-9.6-3.75-3.75L3 13.25zm3.92 1.06h-.92v-.92l7.08-7.08.92.92-7.08 7.08z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Editar
                    </button>
                </div>
            </div>
        </article>
    @empty
        <div class="rounded-3xl border border-slate-500 bg-white/80 p-6 text-center text-sm text-slate-500">
            No hay empleados asignados que coincidan con los filtros.
        </div>
    @endforelse
</div>