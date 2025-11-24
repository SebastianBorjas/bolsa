<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bolsa - Panel administrativo</title>
        <link rel="icon" href="{{ asset('images/logos/lgo.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-white text-slate-900 font-sans">
        @include('bolsa.partials.header')

        <main class="flex flex-1 flex-col pt-20 pb-16 space-y-8">
            <section class="mx-auto w-full max-w-6xl px-6 space-y-6">

                <div class="relative overflow-hidden rounded-3xl border border-white/60 bg-slate-50/90 text-slate-900 shadow-[0_12px_45px_-18px_rgba(15,23,42,0.6)] transition">
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
                                <ul class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="filters" method="GET" action="{{ route('bolsa.index') }}" class="grid gap-5 md:grid-cols-4">
                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500" for="area">Área</label>
                                <select
                                    name="area"
                                    id="area"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/60 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
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
                                    class="w-full rounded-2xl border border-slate-500 bg-white/60 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition disabled:cursor-not-allowed disabled:bg-slate-100"
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
                                    class="h-12 rounded-2xl border border-slate-500 bg-white/60 px-4 text-sm font-semibold text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500" for="order">Ordenar</label>
                                <select
                                    name="order"
                                    id="order"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/60 px-4 py-3 text-sm font-semibold text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
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
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Registros</p>
                            <p class="text-xs text-slate-500">{{ $empleados->count() }} registros</p>
                        </div>
                        <div id="empleados-wrapper" data-fetch-url="{{ route('bolsa.empleados') }}">
                            @include('bolsa.admin.partials.empleados-table')
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('bolsa.partials.footer-registro')

        <div
            id="edit-employee-modal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"
            data-update-base-url="{{ url('/bolsa/admin/empleados') }}"
            data-delete-base-url="{{ url('/bolsa/admin/empleados') }}"
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>
            <div class="relative z-10 w-full max-w-3xl overflow-hidden rounded-3xl border border-white/40 bg-white/80 shadow-2xl">
                <div class="flex max-h-[90vh] flex-col gap-6 overflow-y-auto px-8 py-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Bolsa de trabajo</p>
                            <h2 class="text-2xl font-semibold uppercase tracking-[0.25em] text-slate-900">Editar registro</h2>
                            <p class="text-[0.65rem] uppercase tracking-[0.3em] text-slate-500">
                                Ajusta los datos y guarda los cambios o borra el registro si ya no aplica.
                            </p>
                        </div>
                        <button
                            type="button"
                            data-modal-close
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-500 bg-white text-sm font-semibold text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                            aria-label="Cerrar editor"
                        >
                            ×
                        </button>
                    </div>
                    <form id="edit-employee-form" method="POST" action="" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <section class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Nombre completo</span>
                                <input
                                    type="text"
                                    name="nombre_completo"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                />
                            </label>
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Correo</span>
                                <input
                                    type="email"
                                    name="correo"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                />
                            </label>
                        </section>

                        <section class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Celular</span>
                                <input
                                    type="text"
                                    name="celular"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                />
                            </label>
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Edad</span>
                                <input
                                    type="number"
                                    name="edad"
                                    min="18"
                                    max="99"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                />
                            </label>
                        </section>

                        <section class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Nivel de estudios</span>
                                <select
                                    name="estudios"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                >
                                    <option value="">Selecciona nivel de estudios</option>
                                    @foreach (['primaria','secundaria','preparatoria','universidad','maestria','doctorado'] as $nivel)
                                        <option value="{{ $nivel }}">{{ ucfirst($nivel) }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Experiencia</span>
                                <select
                                    name="experiencia"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                >
                                    <option value="">Selecciona nivel de experiencia</option>
                                    @foreach (['Sin experiencia','0-1 años de experiencia','1-5 años de experiencia','mas de 5 años de experiencia'] as $experiencia)
                                        <option value="{{ $experiencia }}">{{ $experiencia }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </section>

                        <section class="grid gap-4 md:grid-cols-2">
                            <label class="space-y-2">
                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Dispuesto a viajar?</span>
                                <select
                                    name="dispuesto"
                                    class="w-full rounded-2xl border border-slate-500 bg-white/70 px-4 py-3 text-sm text-slate-900 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"
                                >
                                    <option value="">Selecciona una opción</option>
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </label>
                            <div></div>
                        </section>

                        <section class="space-y-3">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Áreas y subáreas (máximo 3)</p>
                            <div
                                id="edit-selected-subareas-container"
                                class="min-h-[3rem] flex flex-wrap gap-2 rounded-2xl border border-dashed border-slate-500 bg-white/80 px-3 py-2"
                            ></div>
                            <p id="edit-subareas-limit-message" class="hidden text-xs uppercase tracking-[0.3em] text-rose-400">
                                Puedes escoger hasta 3 subáreas.
                            </p>
                            <div class="grid gap-4 max-h-[35vh] overflow-y-auto pr-1">
                                @foreach ($areas as $area)
                                    @if ($area->subareas->isNotEmpty())
                                        <div class="rounded-2xl border border-slate-500 bg-white/70" data-area-card>
                                            <button
                                                type="button"
                                                data-area-toggle
                                                class="w-full rounded-2xl border border-transparent bg-transparent px-4 py-3 text-left text-sm font-semibold tracking-[0.25em] text-slate-900"
                                            >
                                                {{ $area->nombre_area }}
                                            </button>
                                            <div class="hidden border-t border-slate-500/80 px-4 py-3" data-area-panel>
                                                <div class="space-y-2">
                                                    @foreach ($area->subareas as $subarea)
                                                        <button
                                                            type="button"
                                                            data-edit-subarea-select
                                                            data-subarea-id="{{ $subarea->id_subarea }}"
                                                            data-subarea-name="{{ $subarea->nombre_subarea }}"
                                                            data-area-name="{{ $area->nombre_area }}"
                                                            class="w-full rounded-2xl border border-slate-500 bg-slate-50 px-4 py-2 text-left text-sm text-slate-900 transition hover:border-red-400 hover:bg-white"
                                                        >
                                                            <div class="flex items-center justify-between">
                                                                <span class="font-semibold">{{ $subarea->nombre_subarea }}</span>
                                                                <span class="text-[0.55rem] uppercase tracking-[0.35em] text-slate-400">
                                                                    Seleccionar
                                                                </span>
                                                            </div>
                                                            <p class="text-[0.6rem] text-slate-500">
                                                                {{ $subarea->descripcion ?? 'Sin descripción' }}
                                                            </p>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div id="edit-selected-subareas-inputs" class="hidden"></div>
                        </section>

                        <div class="flex flex-wrap items-center justify-end gap-3">
                            <button
                                type="button"
                                data-modal-close
                                class="rounded-2xl border border-slate-500 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                            >
                                Cancelar
                            </button>
                            <button
                                type="submit"
                                class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white shadow-lg transition hover:bg-red-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-red-300"
                            >
                                Guardar cambios
                            </button>
                        </div>
                    </form>

                    <form id="delete-employee-form" method="POST" action="" class="border-t border-slate-500/80 pt-4">
                        @csrf
                        @method('DELETE')
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm text-slate-500">
                                ¿Necesitas quitar este registro de la bolsa? Esta acción no se puede deshacer.
                            </p>
                            <button
                                type="submit"
                                class="rounded-2xl border border-rose-400/70 bg-transparent px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-rose-500 transition hover:bg-rose-100"
                            >
                                Eliminar registro
                            </button>
                        </div>
                    </form>
                </div>
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
                const modal = document.getElementById('edit-employee-modal');
                if (!modal) {
                    return;
                }

                const form = document.getElementById('edit-employee-form');
                const deleteForm = document.getElementById('delete-employee-form');
                const updateBase = modal.dataset.updateBaseUrl;
                const deleteBase = modal.dataset.deleteBaseUrl;
                const closeElements = modal.querySelectorAll('[data-modal-close]');
                const selectedContainer = modal.querySelector('#edit-selected-subareas-container');
                const inputsWrapper = modal.querySelector('#edit-selected-subareas-inputs');
                const limitMessage = modal.querySelector('#edit-subareas-limit-message');
                const fields = {
                    nombre: form.querySelector('[name="nombre_completo"]'),
                    correo: form.querySelector('[name="correo"]'),
                    celular: form.querySelector('[name="celular"]'),
                    edad: form.querySelector('[name="edad"]'),
                    estudios: form.querySelector('[name="estudios"]'),
                    experiencia: form.querySelector('[name="experiencia"]'),
                    dispuesto: form.querySelector('[name="dispuesto"]'),
                };

                const selectedSet = new Set();
                const maxSubareas = 3;

                const showLimitMessage = () => {
                    if (!limitMessage) {
                        return;
                    }
                    limitMessage.classList.remove('hidden');
                    if (limitMessage.dataset.timeout) {
                        clearTimeout(limitMessage.dataset.timeout);
                    }
                    limitMessage.dataset.timeout = setTimeout(() => {
                        limitMessage.classList.add('hidden');
                    }, 1800);
                };

                const clearSelectedSubareas = () => {
                    selectedSet.clear();
                    if (selectedContainer) {
                        selectedContainer.innerHTML = '';
                    }
                    if (inputsWrapper) {
                        inputsWrapper.innerHTML = '';
                    }
                    if (limitMessage) {
                        limitMessage.classList.add('hidden');
                    }
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

                const removeChip = (value) => {
                    const key = String(value);
                    selectedSet.delete(key);
                    if (!selectedContainer) {
                        return;
                    }
                    const chip = selectedContainer.querySelector(`[data-edit-subarea-chip][data-subarea-id="${key}"]`);
                    if (chip) {
                        chip.remove();
                    }
                    removeHiddenInput(key);
                };

                const createChip = ({ id, label, area }) => {
                    if (!selectedContainer) {
                        return;
                    }
                    const chip = document.createElement('button');
                    chip.type = 'button';
                    chip.dataset.editSubareaChip = '';
                    chip.dataset.subareaId = id;
                    chip.className =
                        'flex items-center gap-2 rounded-full border border-slate-500 bg-white px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100';
                    chip.title = area || '';
                    chip.innerHTML = `<span>${label}</span><span class="text-[0.55rem] text-slate-400">×</span>`;
                    selectedContainer.appendChild(chip);
                };

                const addSubareaSelection = (id, label, area) => {
                    const key = String(id).trim();
                    if (!key || selectedSet.has(key)) {
                        return;
                    }
                    if (selectedSet.size >= maxSubareas) {
                        showLimitMessage();
                        return;
                    }
                    selectedSet.add(key);
                    createChip({ id: key, label: label || `#${key}`, area });
                    addHiddenInput(key);
                };

                const populateSubareas = (employee) => {
                    clearSelectedSubareas();
                    (employee.subareas || []).forEach((subarea) => {
                        const button = modal.querySelector(`[data-edit-subarea-select][data-subarea-id="${subarea}"]`);
                        const label = button?.dataset?.subareaName || '';
                        const area = button?.dataset?.areaName || '';
                        addSubareaSelection(subarea, label, area);
                    });
                };

                const areaToggles = modal.querySelectorAll('[data-area-toggle]');
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
                        const alreadyOpen = !panel.classList.contains('hidden');
                        closeAllPanels();
                        if (!alreadyOpen) {
                            panel.classList.remove('hidden');
                        }
                    });
                });

                const openModal = () => {
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                };

                const closeModal = () => {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('overflow-hidden');
                    form.reset();
                    clearSelectedSubareas();
                    closeAllPanels();
                };

                const populateModal = (employee) => {
                    form.action = `${updateBase}/${employee.id}`;
                    deleteForm.action = `${deleteBase}/${employee.id}`;
                    fields.nombre.value = employee.nombre_completo || '';
                    fields.correo.value = employee.correo || '';
                    fields.celular.value = employee.celular || '';
                    fields.edad.value = employee.edad || '';
                    fields.estudios.value = employee.estudios || '';
                    fields.experiencia.value = employee.experiencia || '';
                    fields.dispuesto.value = employee.dispuesto || '';
                    populateSubareas(employee);
                };

                document.addEventListener('click', (event) => {
                    const button = event.target.closest('[data-edit-employee-button]');
                    if (!button) {
                        return;
                    }
                    event.preventDefault();
                    const payload = button.dataset.employee ? JSON.parse(button.dataset.employee) : null;
                    if (!payload) {
                        return;
                    }
                    populateModal(payload);
                    openModal();
                });

                modal.addEventListener('click', (event) => {
                    const target = event.target.closest('[data-edit-subarea-select]');
                    if (!target) {
                        return;
                    }
                    event.preventDefault();
                    addSubareaSelection(target.dataset.subareaId, target.dataset.subareaName, target.dataset.areaName);
                });

                if (selectedContainer) {
                    selectedContainer.addEventListener('click', (event) => {
                        const chip = event.target.closest('[data-edit-subarea-chip]');
                        if (!chip) {
                            return;
                        }
                        event.preventDefault();
                        removeChip(chip.dataset.subareaId);
                    });
                }

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
