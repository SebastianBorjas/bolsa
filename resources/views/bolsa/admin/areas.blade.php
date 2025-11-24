<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bolsa - Áreas</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-white text-slate-900 font-sans">
        @include('bolsa.partials.header')

        <main class="flex flex-1 flex-col pt-20 pb-16 space-y-8">
            <section class="mx-auto w-full max-w-6xl px-6 space-y-6">
                <div class="relative -mt-8 md:-mt-10 overflow-hidden rounded-3xl border border-white/60 bg-slate-50/90 text-slate-900 shadow-[0_12px_45px_-18px_rgba(15,23,42,0.6)] transition">
                    <div class="bg-red-600/90 border-b border-red-500/40 px-6 py-4 text-center text-xs uppercase tracking-[0.4em] font-semibold text-white">
                        Panel administrativo
                    </div>
                    <div class="space-y-6 px-8 py-8">
                        <div class="space-y-3 text-center">
                            <p class="text-sm text-slate-500">Administra las áreas y subáreas registradas en la bolsa de empleo.</p>
                        </div>

                        @if (session('status'))
                            <div class="rounded-2xl border border-emerald-400/60 bg-emerald-400/10 px-5 py-3 text-sm text-emerald-900">
                                {{ session('status') }}
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

                        <div class="flex flex-col gap-3 rounded-3xl border border-slate-500 bg-white/90 p-6 lg:flex-row lg:items-center lg:justify-between">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Formularios rápidos</p>
                            <div class="flex flex-wrap gap-3">
                                <button
                                    type="button"
                                    class="rounded-full border border-slate-500 bg-white px-5 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                                    data-form-toggle="area-form"
                                >
                                    Registrar área
                                </button>
                                <button
                                    type="button"
                                    class="rounded-full border border-slate-500 bg-white px-5 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                                    data-form-toggle="subarea-form"
                                >
                                    Registrar subárea
                                </button>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <form
                                id="area-form"
                                action="{{ route('bolsa.areas.store') }}"
                                method="POST"
                                class="hidden space-y-3 rounded-3xl border border-slate-500 bg-white/90 p-6 shadow-xl"
                            >
                                @csrf
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Nueva área</p>
                                <div class="space-y-2">
                                    <label class="text-xs uppercase tracking-[0.3em] text-slate-500">Nombre del área</label>
                                    <input
                                        type="text"
                                        name="nombre_area"
                                        class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    />
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:bg-red-500"
                                    >
                                        Registrar área
                                    </button>
                                </div>
                            </form>

                            <form
                                id="subarea-form"
                                action="{{ route('bolsa.subareas.store') }}"
                                method="POST"
                                class="hidden space-y-3 rounded-3xl border border-slate-500 bg-white/90 p-6 shadow-xl"
                            >
                                @csrf
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Nueva subárea</p>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <label class="space-y-2">
                                        <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Área</span>
                                        <select
                                            name="area_id"
                                            class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                        >
                                            <option value="">Selecciona un área</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id_area }}">{{ $area->nombre_area }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="space-y-2">
                                        <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Nombre de la subárea</span>
                                        <input
                                            type="text"
                                            name="nombre_subarea"
                                            class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                        />
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs uppercase tracking-[0.3em] text-slate-500">Descripción</label>
                                    <textarea
                                        name="descripcion"
                                        rows="2"
                                        class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                    ></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:bg-red-500"
                                    >
                                        Registrar subárea
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="space-y-4">
                            @forelse ($areas as $area)
                                <article class="overflow-hidden rounded-3xl border border-slate-500 bg-white shadow-[0_25px_70px_-20px_rgba(15,23,42,0.4)]">
                                    <div class="flex flex-col gap-4 border-b border-slate-500/80 px-6 py-5">
                                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Área</p>
                                                <p class="text-2xl font-semibold text-slate-900">{{ $area->nombre_area }}</p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="rounded-full border border-emerald-400/70 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.35em] text-emerald-700">
                                                    {{ $area->subareas->count() }} subárea{{ $area->subareas->count() === 1 ? '' : 's' }}
                                                </span>
                                                <button
                                                    type="button"
                                                    data-edit-area
                                                    data-area-name="{{ $area->nombre_area }}"
                                                    data-area-update-url="{{ route('bolsa.areas.update', $area) }}"
                                                    data-area-delete-url="{{ route('bolsa.areas.destroy', $area) }}"
                                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-500 bg-white text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                                                    aria-label="Editar área {{ $area->nombre_area }}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0l-1.037 1.037 2.828 2.828 1.037-1.037a2 2 0 000-2.828z"></path>
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M3 13.25V17h3.75l9.6-9.6-3.75-3.75L3 13.25zm3.92 1.06h-.92v-.92l7.08-7.08.92.92-7.08 7.08z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Subáreas registradas</p>
                                    </div>
                                    <div class="space-y-3 px-6 py-5">
                                        @if ($area->subareas->isEmpty())
                                            <p class="text-sm text-slate-500">Esta área aún no tiene subáreas.</p>
                                        @else
                                            <ul class="space-y-3">
                                                @foreach ($area->subareas as $subarea)
                                                    <li class="rounded-2xl border border-slate-500 bg-slate-950/5 px-6 py-4">
                                                        <div class="flex items-start justify-between gap-4">
                                                            <div class="space-y-1">
                                                                <p class="text-sm font-semibold text-slate-900">{{ $subarea->nombre_subarea }}</p>
                                                                <p class="text-xs text-slate-500">{{ $subarea->descripcion ?: 'Sin descripción' }}</p>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <span class="text-[0.6rem] uppercase tracking-[0.3em] text-slate-500">Subárea</span>
                                                                <button
                                                                    type="button"
                                                                    data-edit-subarea
                                                                    data-subarea-id="{{ $subarea->id_subarea }}"
                                                                    data-subarea-name="{{ $subarea->nombre_subarea }}"
                                                                    data-area-id="{{ $area->id_area }}"
                                                                    data-area-name="{{ $area->nombre_area }}"
                                                                    data-subarea-description="{{ $subarea->descripcion }}"
                                                                    data-subarea-update-url="{{ route('bolsa.subareas.update', $subarea) }}"
                                                                    data-subarea-delete-url="{{ route('bolsa.subareas.destroy', $subarea) }}"
                                                                    class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-500 bg-white text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                                                                    aria-label="Editar subárea {{ $subarea->nombre_subarea }}"
                                                                >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0l-1.037 1.037 2.828 2.828 1.037-1.037a2 2 0 000-2.828z"></path>
                                                                        <path
                                                                            fill-rule="evenodd"
                                                                            d="M3 13.25V17h3.75l9.6-9.6-3.75-3.75L3 13.25zm3.92 1.06h-.92v-.92l7.08-7.08.92.92-7.08 7.08z"
                                                                            clip-rule="evenodd"
                                                                        />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-3xl border border-slate-500 bg-white/90 p-6 text-center text-sm text-slate-500">
                                    Aún no se han registrado áreas.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('bolsa.partials.footer-registro')

        <div
            id="area-edit-modal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>
            <div class="relative z-10 w-full max-w-md overflow-hidden rounded-3xl border border-slate-500 bg-white p-6 shadow-2xl">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Editar área</p>
                        <h3 class="text-xl font-semibold text-slate-900">Actualiza el nombre del área</h3>
                    </div>
                    <button
                        type="button"
                        data-modal-close
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-500 bg-slate-100 text-slate-900 transition hover:border-slate-500 hover:bg-white"
                        aria-label="Cerrar modal de área"
                    >
                        ×
                    </button>
                </div>
                <form id="area-edit-form" method="POST" action="" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <label class="space-y-2">
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Nombre del área</span>
                        <input
                            type="text"
                            name="nombre_area"
                            class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                        />
                    </label>
                    <div class="flex justify-end gap-3 mt-4">
                        <button
                            type="button"
                            data-modal-close
                            class="rounded-2xl border border-slate-500 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-red-500"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </form>
                <form id="area-delete-form" method="POST" action="" class="mt-5 border-t border-slate-500/80 pt-4">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Eliminar esta área eliminará también sus subáreas.</p>
                        <button
                            type="submit"
                            class="rounded-2xl border border-rose-400/70 bg-transparent px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-rose-500 transition hover:bg-rose-100"
                        >
                            Eliminar área
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div
            id="subarea-edit-modal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>
            <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-3xl border border-slate-500 bg-white p-6 shadow-2xl">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Editar subárea</p>
                        <h3 class="text-xl font-semibold text-slate-900">Modifica su información</h3>
                    </div>
                    <button
                        type="button"
                        data-modal-close
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-500 bg-slate-100 text-slate-900 transition hover:border-slate-500 hover:bg-white"
                        aria-label="Cerrar modal de subárea"
                    >
                        ×
                    </button>
                </div>
                <form id="subarea-edit-form" method="POST" action="" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2">
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Área</span>
                            <select
                                name="area_id"
                                class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                            >
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id_area }}">{{ $area->nombre_area }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="space-y-2">
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Nombre de la subárea</span>
                            <input
                                type="text"
                                name="nombre_subarea"
                                class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                            />
                        </label>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-500">Descripción</label>
                        <textarea
                            name="descripcion"
                            rows="2"
                            class="w-full rounded-2xl border border-slate-500 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                        ></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button
                            type="button"
                            data-modal-close
                            class="rounded-2xl border border-slate-500 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="rounded-2xl bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-red-500"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </form>
                <form id="subarea-delete-form" method="POST" action="" class="mt-5 border-t border-slate-500/80 pt-4">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Eliminar esta subárea no puede revertirse.</p>
                        <button
                            type="submit"
                            class="rounded-2xl border border-rose-400/70 bg-transparent px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-rose-500 transition hover:bg-rose-100"
                        >
                            Eliminar subárea
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toggles = document.querySelectorAll('[data-form-toggle]');
                toggles.forEach((toggle) => {
                    const targetId = toggle.dataset.formToggle;
                    const target = document.getElementById(targetId);
                    if (!target) {
                        return;
                    }
                    toggle.addEventListener('click', () => {
                        target.classList.toggle('hidden');
                        if (!target.classList.contains('hidden')) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
                });

                const areaModal = document.getElementById('area-edit-modal');
                const areaForm = areaModal?.querySelector('#area-edit-form');
                const areaDeleteForm = areaModal?.querySelector('#area-delete-form');
                const areaInput = areaForm?.querySelector('[name="nombre_area"]');
                const subareaModal = document.getElementById('subarea-edit-modal');
                const subareaForm = subareaModal?.querySelector('#subarea-edit-form');
                const subareaDeleteForm = subareaModal?.querySelector('#subarea-delete-form');
                const subareaSelect = subareaForm?.querySelector('[name="area_id"]');
                const subareaNameInput = subareaForm?.querySelector('[name="nombre_subarea"]');
                const subareaDescInput = subareaForm?.querySelector('[name="descripcion"]');

                const openModal = (modal) => {
                    if (!modal) {
                        return;
                    }
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                };

                const closeModal = (modal) => {
                    if (!modal) {
                        return;
                    }
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('overflow-hidden');
                };

                document.addEventListener('click', (event) => {
                    const button = event.target.closest('[data-edit-area]');
                    if (!button || !areaModal) {
                        return;
                    }
                    event.preventDefault();
                    areaForm.action = button.dataset.areaUpdateUrl ?? '';
                    areaDeleteForm.action = button.dataset.areaDeleteUrl ?? '';
                    if (areaInput) {
                        areaInput.value = button.dataset.areaName ?? '';
                    }
                    openModal(areaModal);
                });

                document.addEventListener('click', (event) => {
                    const button = event.target.closest('[data-edit-subarea]');
                    if (!button || !subareaModal) {
                        return;
                    }
                    event.preventDefault();
                    subareaForm.action = button.dataset.subareaUpdateUrl ?? '';
                    subareaDeleteForm.action = button.dataset.subareaDeleteUrl ?? '';
                    if (subareaSelect && button.dataset.areaId) {
                        subareaSelect.value = button.dataset.areaId;
                    }
                    if (subareaNameInput) {
                        subareaNameInput.value = button.dataset.subareaName ?? '';
                    }
                    if (subareaDescInput) {
                        subareaDescInput.value = button.dataset.subareaDescription ?? '';
                    }
                    openModal(subareaModal);
                });

                const modalCloseElements = document.querySelectorAll('[data-modal-close]');
                modalCloseElements.forEach((element) => {
                    element.addEventListener('click', (event) => {
                        event.preventDefault();
                        const targetModal = element.closest('#area-edit-modal, #subarea-edit-modal');
                        closeModal(targetModal);
                    });
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key !== 'Escape') {
                        return;
                    }
                    if (areaModal && !areaModal.classList.contains('hidden')) {
                        closeModal(areaModal);
                    }
                    if (subareaModal && !subareaModal.classList.contains('hidden')) {
                        closeModal(subareaModal);
                    }
                });
            });
        </script>
    </body>
</html>
