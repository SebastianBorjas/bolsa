<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Registro de empleados - Bolsa</title>
        <link rel="icon" href="{{ asset('images/logos/lgo.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-white text-slate-900 font-sans">
        @include('bolsa.partials.header-registro')

        <main class="flex flex-1 flex-col pt-20 pb-10">
            <section class="mx-auto w-full max-w-6xl px-6 py-10 space-y-8">
                @php
                    $selectedSubareasOld = old('subareas', []);
                    $subareaLookup = [];
                    foreach ($areas as $area) {
                        foreach ($area->subareas as $subarea) {
                            $subareaLookup[$subarea->id_subarea] = [
                                'name' => $subarea->nombre_subarea,
                                'description' => $subarea->descripcion ?? '',
                                'area' => $area->nombre_area,
                            ];
                        }
                    }
                @endphp

                <div class="space-y-5">
                    @if (session('success'))
                        <div class="rounded-2xl border border-emerald-400/60 bg-emerald-400/10 px-5 py-3 text-sm text-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div
                            class="rounded-2xl border border-red-700 bg-gradient-to-br from-red-700 via-red-600 to-red-500 px-5 py-3 text-sm text-white shadow-lg"
                            role="alert"
                            aria-live="assertive"
                        >
                            <ul class="list-disc space-y-1 pl-5 text-white">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="relative -mt-10 rounded-3xl border border-white/60 bg-slate-50/90 p-0 overflow-hidden shadow-2xl shadow-black/80 transition text-slate-900 backdrop-blur-3xl">
                    <div class="bg-red-600/90 border-b border-red-500/40 px-6 py-4 text-center text-xs uppercase tracking-[0.4em] font-semibold text-white">
                        REGISTRAR CURRICULUM
                    </div>
                    <form
                        action="{{ route('bolsa.registro.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="space-y-8 px-8 py-8"
                        id="registro-form"
                    >
                        @csrf
                        <section class="space-y-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">
                                Datos personales
                            </p>
                            <div class="grid gap-5 md:grid-cols-3">
                                <label class="space-y-2">
                                    <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Nombre</span>
                                    <input
                                        type="text"
                                        name="nombre"
                                        value="{{ old('nombre') }}"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </label>
                                <label class="space-y-2">
                                    <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Apellido paterno</span>
                                    <input
                                        type="text"
                                        name="paterno"
                                        value="{{ old('paterno') }}"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </label>
                                <label class="space-y-2">
                                    <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Apellido materno</span>
                                    <input
                                        type="text"
                                        name="materno"
                                        value="{{ old('materno') }}"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </label>
                            </div>

                            <div class="grid gap-5 md:grid-cols-3">
                                <label class="space-y-2">
                                    <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Correo</span>
                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </label>
                                <label class="space-y-2">
                                    <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Telefono</span>
                                    <input
                                        type="text"
                                        name="telefono"
                                        value="{{ old('telefono') }}"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </label>
                                <label class="space-y-2">
                                    <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Edad</span>
                                    <input
                                        type="number"
                                        name="edad"
                                        min="18"
                                        max="99"
                                        value="{{ old('edad') }}"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </label>
                            </div>
                        </section>

                        <section class="grid gap-5 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Nivel de estudios</span>
                                    <select
                                        name="estudios"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    >
                                    <option value="">Selecciona nivel de estudios</option>
                                    @foreach (['primaria','secundaria','preparatoria','universidad','maestria','doctorado'] as $nivel)
                                        <option value="{{ $nivel }}" @selected(old('estudios') === $nivel)>{{ ucfirst($nivel) }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Experiencia</span>
                                    <select
                                        name="experiencia"
                                        class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    >
                                    <option value="">Selecciona nivel de experiencia</option>
                            @foreach (['Sin experiencia','0-1 años de experiencia','1-5 años de experiencia','mas de 5 años de experiencia'] as $experiencia)
                                        <option value="{{ $experiencia }}" @selected(old('experiencia') === $experiencia)>{{ $experiencia }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </section>

                        <section class="space-y-5">
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Dispuesto a viajar?</span>
                            <select
                                name="dispuesto"
                                class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                            >
                                <option value="">Selecciona una opcion</option>
                                <option value="si" @selected(old('dispuesto') === 'si')>Si</option>
                                <option value="no" @selected(old('dispuesto') === 'no')>No</option>
                            </select>
                        </section>

                        <section class="space-y-3">
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-600 font-semibold">Curriculum (PDF, maximo 2 MB)</span>
                            <input
                                type="file"
                                name="curriculum"
                                accept="application/pdf"
                                class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                            />
                        </section>

                        <section class="space-y-4">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500 font-semibold">
                                Subareas (selecciona al menos 1, maximo 3, o escribe una sugerencia)
                            </p>
                            <div class="flex flex-wrap gap-4 rounded-2xl border border-slate-400 bg-white p-4 shadow-inner text-slate-900">
                                <span class="text-xs uppercase tracking-[0.4em] text-slate-500 font-semibold">Seleccionados</span>
                                <div id="selected-subareas-container" class="flex flex-wrap gap-4">
                                    @foreach ($selectedSubareasOld as $selectedId)
                                        @if (isset($subareaLookup[$selectedId]))
                                            <div
                                                class="flex cursor-pointer flex-col gap-0.5 rounded-full border border-slate-300 bg-slate-100/80 px-3 py-2 text-sm text-slate-900 transition hover:ring-1 hover:ring-red-400/60"
                                                data-subarea-chip
                                                data-subarea-id="{{ $selectedId }}"
                                                data-area-name="{{ $subareaLookup[$selectedId]['area'] }}"
                                                data-description="{{ $subareaLookup[$selectedId]['description'] }}"
                                                title="{{ $subareaLookup[$selectedId]['description'] ?? 'Sin descripción' }}"
                                            >
                                                <span class="font-semibold">{{ $subareaLookup[$selectedId]['name'] }}</span>
                                                <span class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500">
                                                    {{ $subareaLookup[$selectedId]['area'] }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        <section class="space-y-4">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500 font-semibold">Areas y subareas</p>
                            <div class="grid grid-cols-1 gap-4 py-4">
                                @foreach ($areas as $area)
                                    <div class="rounded-3xl border border-slate-400 bg-white text-slate-900 transition hover:border-red-600/70 overflow-hidden" data-area-card>
                                        <button
                                            type="button"
                                            data-area-toggle
                                            class="w-full rounded-3xl border border-transparent bg-transparent px-5 py-4 text-left text-lg font-semibold tracking-[0.25em] text-slate-900 transition focus-visible:outline-none focus-visible:ring focus-visible:ring-white/30"
                                        >
                                            {{ $area->nombre_area }}
                                        </button>
                                        <div class="hidden border-t border-red-400/40 bg-white/90 px-5 py-4 text-slate-900 rounded-b-3xl" data-area-panel>
                                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                                @foreach ($area->subareas as $subarea)
                                                    <div
                                                        class="relative overflow-hidden rounded-2xl border border-slate-400 bg-white/70 px-4 py-4 transition hover:border-red-500/60 hover:bg-white"
                                                        data-subarea-card
                                                        data-subarea-id="{{ $subarea->id_subarea }}"
                                                        data-subarea-name="{{ $subarea->nombre_subarea }}"
                                                        data-area-name="{{ $area->nombre_area }}"
                                                        data-description="{{ $subarea->descripcion }}"
                                                        @if (in_array($subarea->id_subarea, $selectedSubareasOld)) hidden @endif
                                                    >
                                                        <button
                                                            type="button"
                                                            data-subarea-select
                                                        class="w-full rounded-2xl bg-transparent pl-4 pr-12 py-3 text-left text-sm font-semibold text-slate-900 focus:outline-none"
                                                        >
                                                            {{ $subarea->nombre_subarea }}
                                                        </button>
                                                        <button
                                                            type="button"
                                                        class="absolute top-3 right-3 rounded-full border border-red-500 bg-red-600/80 px-3 py-1 text-[0.6rem] uppercase tracking-[0.3em] text-white transition hover:border-red-400 hover:bg-red-500"
                                                            data-subarea-info
                                                            aria-expanded="false"
                                                        >
                                                            info
                                                        </button>
                                                        <p
                                                            class="hidden px-4 pb-3 pt-1 text-xs text-slate-600"
                                                            data-subarea-description
                                                        >
                                                            {{ $subarea->descripcion ?? 'Sin descripción' }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p id="subareas-limit-message" class="mt-4 hidden text-xs uppercase tracking-[0.3em] text-rose-300">
                                Solo puedes elegir hasta 3 subareas.
                            </p>
                        </section>

                        <section class="space-y-4">
                            <div class="space-y-3 rounded-2xl border border-slate-400 bg-white p-4 shadow-md">
                                <div class="flex flex-col gap-2 text-sm font-semibold text-slate-900/80 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="uppercase tracking-[0.3em] text-xs text-slate-600">
                                        Si no encontraste tu vocación, sugiere una
                                    </p>
                                    <button
                                        type="button"
                                        data-suggestion-toggle
                                        aria-expanded="false"
                                    class="w-full rounded-2xl border border-red-500 bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:bg-red-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-red-300 sm:w-auto"
                                    >
                                        Sugiere otra
                                    </button>
                                </div>
                                <textarea
                                    name="sugerencia"
                                    rows="3"
                                    data-suggestion-area
                                    class="hidden w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    placeholder="Describe una ocupación o campo que no esté listado..."
                                >{{ old('sugerencia') }}</textarea>
                            </div>
                        </section>

                        <div id="subareas-inputs">
                            @foreach ($selectedSubareasOld as $selectedId)
                                <input type="hidden" name="subareas[]" value="{{ $selectedId }}" />
                            @endforeach
                        </div>

                        <div class="text-right">
                            <button
                                type="submit"
                                class="w-full rounded-2xl bg-red-600 px-4 py-3 text-xs font-semibold uppercase tracking-[0.4em] text-white shadow-lg transition hover:bg-red-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-red-300"
                            >
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>

        @include('bolsa.partials.footer-registro')

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const areaToggles = document.querySelectorAll('[data-area-toggle]');
                const limitMessage = document.getElementById('subareas-limit-message');
                const selectsHidden = document.getElementById('subareas-inputs');
                const selectedContainer = document.getElementById('selected-subareas-container');
                const maxSelection = 3;
                const selectedSet = new Set(
                    Array.from(document.querySelectorAll('#subareas-inputs input')).map((input) => input.value)
                );
                const suggestionToggle = document.querySelector('[data-suggestion-toggle]');
                const suggestionArea = document.querySelector('[data-suggestion-area]');

                const showLimitMessage = () => {
                    limitMessage.classList.remove('hidden');
                    if (limitMessage.dataset.timeout) {
                        clearTimeout(Number(limitMessage.dataset.timeout));
                    }
                    limitMessage.dataset.timeout = setTimeout(() => limitMessage.classList.add('hidden'), 1800);
                };

                const closeAllPanels = () => {
                    document.querySelectorAll('[data-area-panel]').forEach((panel) => panel.classList.add('hidden'));
                };

                closeAllPanels();

                const toggleSuggestionArea = () => {
                    if (!suggestionArea || !suggestionToggle) {
                        return;
                    }
                    const wasHidden = suggestionArea.classList.contains('hidden');
                    suggestionArea.classList.toggle('hidden');
                    const isVisible = !wasHidden;
                    suggestionToggle.setAttribute('aria-expanded', isVisible.toString());
                    if (isVisible) {
                        suggestionArea.focus();
                    }
                };

                if (suggestionArea && suggestionArea.value.trim()) {
                    suggestionArea.classList.remove('hidden');
                    suggestionToggle?.setAttribute('aria-expanded', 'true');
                }

                suggestionToggle?.addEventListener('click', (event) => {
                    event.preventDefault();
                    toggleSuggestionArea();
                });

                areaToggles.forEach((toggle) => {
                    toggle.addEventListener('click', () => {
                        const card = toggle.closest('[data-area-card]');
                        const panel = card.querySelector('[data-area-panel]');
                        const alreadyOpen = !panel.classList.contains('hidden');
                        closeAllPanels();
                        if (!alreadyOpen) {
                            panel.classList.remove('hidden');
                        }
                    });
                });

                const createChip = ({ id, areaName, name, description }) => {
                    const chip = document.createElement('div');
                    chip.setAttribute('data-subarea-chip', '');
                    chip.setAttribute('data-subarea-id', id);
                    chip.dataset.areaName = areaName;
                    chip.dataset.description = description;
                    chip.title = description || 'Sin descripción';
                    chip.className =
                        'flex cursor-pointer flex-col gap-0.5 rounded-full border border-slate-300 bg-slate-100/80 px-3 py-2 text-sm text-slate-900 transition hover:ring-1 hover:ring-red-400/60';

                    const label = document.createElement('span');
                    label.className = 'font-semibold';
                    label.textContent = name;

                    const areaLabel = document.createElement('span');
                    areaLabel.className = 'text-[0.6rem] uppercase tracking-[0.3em] text-slate-600';
                    areaLabel.textContent = areaName || '';

                    chip.appendChild(label);
                    chip.appendChild(areaLabel);
                    selectedContainer.appendChild(chip);
                };

                const addHiddenInput = (id) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'subareas[]';
                    input.value = id;
                    selectsHidden.appendChild(input);
                };

                const removeHiddenInput = (id) => {
                    const input = selectsHidden.querySelector(`input[value="${id}"]`);
                    if (input) {
                        input.remove();
                    }
                };

                const resetCardVisibility = (card) => {
                    const descriptionEl = card.querySelector('[data-subarea-description]');
                    if (descriptionEl) {
                        descriptionEl.classList.add('hidden');
                    }
                    const infoButton = card.querySelector('[data-subarea-info]');
                    if (infoButton) {
                        infoButton.setAttribute('aria-expanded', 'false');
                    }
                };

                const handleRemoval = (chip) => {
                    const id = chip.dataset.subareaId;
                    selectedSet.delete(id);
                    const card = document.querySelector(`[data-subarea-card][data-subarea-id="${id}"]`);
                    if (card) {
                        card.hidden = false;
                        resetCardVisibility(card);
                    }
                    chip.remove();
                    removeHiddenInput(id);
                };

                selectedContainer.addEventListener('click', (event) => {
                    const chip = event.target.closest('[data-subarea-chip]');
                    if (chip) {
                        handleRemoval(chip);
                    }
                });

                document.querySelectorAll('[data-subarea-select]').forEach((button) => {
                    button.addEventListener('click', () => {
                        const card = button.closest('[data-subarea-card]');
                        if (!card) {
                            return;
                        }
                        const id = card.dataset.subareaId;
                        if (selectedSet.has(id)) {
                            return;
                        }
                        if (selectedSet.size >= maxSelection) {
                            showLimitMessage();
                            return;
                        }

                        selectedSet.add(id);
                        card.hidden = true;
                        resetCardVisibility(card);

                        createChip({
                            id,
                            areaName: card.dataset.areaName,
                            name: card.dataset.subareaName || '',
                            description: card.dataset.description,
                        });
                        addHiddenInput(id);
                    });
                });

                document.querySelectorAll('[data-subarea-info]').forEach((infoButton) => {
                    infoButton.addEventListener('click', (event) => {
                        event.stopPropagation();
                        const card = infoButton.closest('[data-subarea-card]');
                        if (!card) {
                            return;
                        }
                        const descriptionEl = card.querySelector('[data-subarea-description]');
                        if (!descriptionEl) {
                            return;
                        }
                        const isHidden = descriptionEl.classList.toggle('hidden');
                        infoButton.setAttribute('aria-expanded', (!isHidden).toString());
                    });
                });

                const registroForm = document.getElementById('registro-form');
                const submitButton = registroForm?.querySelector('[type="submit"]');
                if (registroForm && submitButton) {
                    registroForm.addEventListener('submit', () => {
                        submitButton.setAttribute('disabled', '');
                        submitButton.classList.add('opacity-60', 'cursor-not-allowed');
                    });
                }
            });
        </script>
    </body>
</html>
