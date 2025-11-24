<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bolsa - Sugerencias</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-white text-slate-900 font-sans">
        @include('bolsa.partials.header')

        <main class="flex flex-1 flex-col pt-20 pb-16 space-y-8">
            <section class="mx-auto w-full max-w-6xl px-6 space-y-6">
                <div class="relative overflow-hidden rounded-3xl border border-white/60 bg-slate-50/90 text-slate-900 shadow-[0_12px_45px_-18px_rgba(15,23,42,0.6)]">
                    <div class="bg-red-600/90 border-b border-red-500/40 px-6 py-4 text-center text-xs uppercase tracking-[0.4em] font-semibold text-white">
                        Panel administrativo
                    </div>
                    <div class="space-y-6 px-8 py-8">
                        @if (session('status'))
                            <div class="rounded-2xl border border-emerald-400/60 bg-emerald-400/10 px-5 py-3 text-sm text-emerald-900">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="rounded-2xl border border-rose-400/60 bg-rose-400/10 px-5 py-3 text-sm text-rose-900">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="rounded-2xl border border-rose-400/60 bg-rose-400/10 px-5 py-3 text-sm text-rose-900">
                                <ul class="list-disc space-y-1 pl-5 text-slate-900">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="filters" method="GET" action="{{ route('bolsa.sugerencias') }}" class="grid gap-5 md:grid-cols-4">
                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500" for="area">Área</label>
                                <select
                                    name="area"
                                    id="area"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/60 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                >
                                    <option value="">Todas las áreas</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id_area }}" @selected($selectedArea == $area->id_area)>
                                            {{ $area->nombre_area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500" for="subarea">Subárea</label>
                                <select
                                    name="subarea"
                                    id="subarea"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/60 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition disabled:cursor-not-allowed disabled:bg-slate-100"
                                    @if (! $selectedArea) disabled title="Selecciona un área primero" @endif
                                >
                                    @include('bolsa.admin.partials.subarea-options')
                                </select>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500" for="search">Buscar</label>
                                <input
                                    type="text"
                                    name="search"
                                    id="search"
                                    value="{{ $search }}"
                                    placeholder="Nombre o correo"
                                    class="h-12 rounded-2xl border border-slate-500 bg-white/60 px-4 text-sm font-semibold text-slate-900 placeholder:text-slate-500 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500" for="order">Ordenar</label>
                                <select
                                    name="order"
                                    id="order"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/60 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                >
                                    <option value="fecha_desc" @selected($order === 'fecha_desc')>Fecha (más recientes arriba)</option>
                                    <option value="nombre_asc" @selected($order === 'nombre_asc')>Nombre (A → Z)</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section class="mx-auto w-full max-w-6xl px-6">
                <div class="relative -mt-6 overflow-hidden rounded-3xl border border-white/60 bg-slate-50/90 text-slate-900 shadow-[0_12px_45px_-18px_rgba(15,23,42,0.6)]">
                    <div class="space-y-6 px-8 py-10">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Sugerencias</p>
                            <p class="text-xs text-slate-500">{{ $empleados->count() }} registros</p>
                        </div>
                        <div id="empleados-wrapper" data-fetch-url="{{ route('bolsa.empleados', ['assigned' => '0']) }}">
                            @include('bolsa.admin.partials.sugerencias-table')
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('bolsa.partials.footer-registro')

        <div
            id="reassign-modal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>
            <div class="relative z-10 w-full max-w-3xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl">
                <div class="flex items-start justify-between gap-4 px-6 py-5">
                    <div>
                        <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Reasignar</p>
                        <h3 class="text-2xl font-semibold text-slate-900">Selecciona subáreas</h3>
                        <p class="text-[0.65rem] uppercase tracking-[0.3em] text-slate-500">
                            Elige hasta 3 subáreas antes de guardar la asignación.
                        </p>
                    </div>
                    <button
                        type="button"
                        data-modal-close
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 bg-slate-100 text-slate-900 transition hover:border-slate-400 hover:bg-white"
                        aria-label="Cerrar modal"
                    >
                        ×
                    </button>
                </div>
                <form id="reassign-form" method="POST" action="" class="space-y-4 px-6 pb-6">
                    @csrf
                    @method('PUT')
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Subáreas seleccionadas</p>
                    <div id="reassign-selected-subareas" class="min-h-[3rem] flex flex-wrap gap-2 rounded-2xl border border-dashed border-slate-400 bg-slate-50 px-3 py-2"></div>
                    <div id="reassign-subareas-inputs" class="hidden"></div>
                    <p id="reassign-subareas-limit" class="hidden text-xs uppercase tracking-[0.3em] text-rose-400">
                        Solo puedes seleccionar hasta 3 subáreas.
                    </p>
                    <div class="grid gap-4 max-h-[35vh] overflow-y-auto pr-1">
                        @foreach ($areas as $area)
                            @if ($area->subareas->isNotEmpty())
                                <div class="rounded-2xl border border-slate-300 bg-slate-50" data-area-card>
                                    <button
                                        type="button"
                                        data-area-toggle
                                        class="w-full rounded-2xl border border-transparent bg-transparent px-4 py-3 text-left text-sm font-semibold tracking-[0.25em] text-slate-900"
                                    >
                                        {{ $area->nombre_area }}
                                    </button>
                                    <div class="hidden border-t border-slate-300/80 px-4 py-3" data-area-panel>
                                        <div class="space-y-2">
                                            @foreach ($area->subareas as $subarea)
                                                <button
                                                    type="button"
                                                    data-reassign-subarea-select
                                                    data-subarea-id="{{ $subarea->id_subarea }}"
                                                    data-subarea-name="{{ $subarea->nombre_subarea }}"
                                                    data-area-name="{{ $area->nombre_area }}"
                                                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2 text-left text-sm text-slate-900 transition hover:border-red-400 hover:bg-white/70"
                                                >
                                                    <div class="flex items-center justify-between">
                                                        <span class="font-semibold">{{ $subarea->nombre_subarea }}</span>
                                                        <span class="text-[0.55rem] uppercase tracking-[0.35em] text-slate-500">
                                                            Seleccionar
                                                        </span>
                                                    </div>
                                                    <p class="text-[0.6rem] text-slate-500">
                                                        {{ $subarea->descripcion ?: 'Sin descripción' }}
                                                    </p>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="flex flex-wrap justify-end gap-3">
                        <button
                            type="button"
                            data-modal-close
                            class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-400 hover:bg-slate-100"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-red-500"
                        >
                            Guardar asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('filters');
                const areaSelect = form.querySelector('select[name="area"]');
                const subareaSelect = form.querySelector('select[name="subarea"]');
                const orderSelect = form.querySelector('select[name="order"]');
                const searchInput = form.querySelector('input[name="search"]');
                const wrapper = document.getElementById('empleados-wrapper');
                const fetchUrl = wrapper.dataset.fetchUrl;

                const toggleSubarea = () => {
                    if (!areaSelect.value) {
                        subareaSelect.disabled = true;
                        subareaSelect.setAttribute('disabled', 'disabled');
                        subareaSelect.value = '';
                        subareaSelect.setAttribute('title', 'Selecciona un área primero');
                    } else {
                        subareaSelect.disabled = false;
                        subareaSelect.removeAttribute('disabled');
                        subareaSelect.removeAttribute('title');
                    }
                };

                const fetchData = async () => {
                    const params = new URLSearchParams({
                        area: areaSelect.value,
                        subarea: subareaSelect.value,
                        search: searchInput.value,
                        order: orderSelect.value,
                    });

                    const response = await fetch(`${fetchUrl}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                    const data = await response.json();
                    wrapper.innerHTML = data.table;
                    subareaSelect.innerHTML = data.subareas;
                    toggleSubarea();
                };

                areaSelect.addEventListener('change', () => {
                    subareaSelect.value = '';
                    fetchData();
                });
                subareaSelect.addEventListener('change', fetchData);
                orderSelect.addEventListener('change', fetchData);
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    fetchData();
                });

                let debounce;
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounce);
                    debounce = setTimeout(fetchData, 400);
                });

                toggleSubarea();
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('reassign-modal');
                if (!modal) {
                    return;
                }

                const form = document.getElementById('reassign-form');
                const selectedContainer = document.getElementById('reassign-selected-subareas');
                const inputsWrapper = document.getElementById('reassign-subareas-inputs');
                const limitMessage = document.getElementById('reassign-subareas-limit');
                const areaToggles = modal.querySelectorAll('[data-area-toggle]');
                const closeElements = modal.querySelectorAll('[data-modal-close]');
                const maxSelections = 3;
                const selectedSet = new Set();

                let limitTimeout;

                const showLimit = () => {
                    if (!limitMessage) {
                        return;
                    }
                    limitMessage.classList.remove('hidden');
                    if (limitTimeout) {
                        clearTimeout(limitTimeout);
                    }
                    limitTimeout = setTimeout(() => limitMessage.classList.add('hidden'), 1800);
                };

                const resetSelections = () => {
                    selectedSet.clear();
                    if (selectedContainer) {
                        selectedContainer.innerHTML = '';
                    }
                    if (inputsWrapper) {
                        inputsWrapper.innerHTML = '';
                    }
                    limitMessage?.classList.add('hidden');
                };

                const addHiddenInput = (value) => {
                    if (!inputsWrapper) {
                        return;
                    }
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'subareas[]';
                    input.value = value;
                    inputsWrapper.appendChild(input);
                };

                const removeHiddenInput = (value) => {
                    if (!inputsWrapper) {
                        return;
                    }
                    const existing = inputsWrapper.querySelector(`input[value="${value}"]`);
                    if (existing) {
                        existing.remove();
                    }
                };

                const createChip = (id, label) => {
                    if (!selectedContainer) {
                        return;
                    }
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.dataset.reassignSubareaChip = '';
                    button.dataset.subareaId = id;
                    button.className =
                        'flex items-center gap-2 rounded-full border border-slate-300 bg-white px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-400 hover:bg-slate-100';
                    button.innerHTML = `${label}<span class="text-[0.55rem] text-slate-400">×</span>`;
                    selectedContainer.appendChild(button);
                };

                const selectSubarea = (id, label) => {
                    const key = String(id);
                    if (!key || selectedSet.has(key)) {
                        return;
                    }
                    if (selectedSet.size >= maxSelections) {
                        showLimit();
                        return;
                    }
                    selectedSet.add(key);
                    createChip(key, label);
                    addHiddenInput(key);
                };

                const deselectSubarea = (id) => {
                    const key = String(id);
                    if (!key || !selectedSet.has(key)) {
                        return;
                    }
                    selectedSet.delete(key);
                    const chip = selectedContainer?.querySelector(`[data-reassign-subarea-chip][data-subarea-id="${key}"]`);
                    if (chip) {
                        chip.remove();
                    }
                    removeHiddenInput(key);
                };

                const openModal = () => {
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                };

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('overflow-hidden');
                    resetSelections();
                };

                const populateSelections = (employee) => {
                    resetSelections();
                    (employee.subareas || []).forEach((subareaId) => {
                        const button = modal.querySelector(`[data-reassign-subarea-select][data-subarea-id="${subareaId}"]`);
                        const label = button?.dataset?.subareaName || `#${subareaId}`;
                        selectSubarea(subareaId, label);
                    });
                };

                const closeAllPanels = () => {
                    modal.querySelectorAll('[data-area-panel]').forEach((panel) => panel.classList.add('hidden'));
                };

                areaToggles.forEach((toggle) => {
                    toggle.addEventListener('click', (event) => {
                        event.preventDefault();
                        const card = toggle.closest('[data-area-card]');
                        const panel = card?.querySelector('[data-area-panel]');
                        if (!panel) {
                            return;
                        }
                        const isOpen = !panel.classList.contains('hidden');
                        closeAllPanels();
                        if (!isOpen) {
                            panel.classList.remove('hidden');
                        }
                    });
                });

                document.addEventListener('click', (event) => {
                    const button = event.target.closest('[data-reassign-employee]');
                    if (!button) {
                        return;
                    }
                    event.preventDefault();
                    const payload = button.dataset.reassignEmployee
                        ? JSON.parse(button.dataset.reassignEmployee)
                        : null;
                    if (!payload) {
                        return;
                    }
                    form.action = payload.updateUrl ?? '';
                    if (payload.subareas) {
                        populateSelections(payload);
                    }
                    openModal();
                });

                modal.addEventListener('click', (event) => {
                    const selector = event.target.closest('[data-reassign-subarea-select]');
                    if (!selector) {
                        return;
                    }
                    event.preventDefault();
                    selectSubarea(selector.dataset.subareaId, selector.dataset.subareaName);
                });

                selectedContainer?.addEventListener('click', (event) => {
                    const chip = event.target.closest('[data-reassign-subarea-chip]');
                    if (!chip) {
                        return;
                    }
                    event.preventDefault();
                    deselectSubarea(chip.dataset.subareaId);
                });

                closeElements.forEach((element) => {
                    element.addEventListener('click', (event) => {
                        event.preventDefault();
                        closeModal();
                    });
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });
            });
        </script>
    </body>
</html>
