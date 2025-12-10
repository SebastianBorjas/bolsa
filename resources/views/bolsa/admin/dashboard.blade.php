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



                <div class="relative -mt-8 md:-mt-10 overflow-hidden rounded-3xl border border-white/60 bg-slate-50/90 text-slate-900 shadow-[0_12px_45px_-18px_rgba(15,23,42,0.6)] transition">

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

                <div class="relative mt-0 lg:-mt-6 overflow-hidden rounded-3xl border border-white/60 bg-slate-50/90 text-slate-900 shadow-[0_12px_45px_-18px_rgba(15,23,42,0.6)]">

                    <div class="space-y-6 px-8 py-10">

                        <div class="flex items-center justify-between gap-4 flex-wrap">

                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-500">Registros</p>

                            <div class="flex flex-wrap items-center gap-3">

                                <button

                                    type="button"

                                    id="bulk-start"

                                    class="rounded-full border border-blue-500 bg-blue-50 px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-blue-800 transition hover:border-blue-600 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring focus-visible:ring-blue-200"

                                >

                                    Enviar varios

                                </button>

                                <div id="bulk-actions" class="hidden items-center gap-3">

                                    <button

                                        type="button"

                                        id="bulk-cancel"

                                        class="rounded-full border border-slate-500 bg-white px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-600 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring focus-visible:ring-slate-200"

                                    >

                                        X

                                    </button>

                                    <button

                                        type="button"

                                        id="bulk-confirm"

                                        class="rounded-full border border-emerald-500 bg-emerald-50 px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-emerald-800 transition hover:border-emerald-600 hover:bg-emerald-100 focus-visible:outline-none focus-visible:ring focus-visible:ring-emerald-200"

                                    >

                                        Confirmar envío

                                    </button>

                                    <span id="bulk-count" class="text-xs text-slate-500"></span>

                                </div>

                                <p class="text-xs text-slate-500">{{ $empleados->total() }} registros</p>

                            </div>

                        </div>

                        <div id="empleados-wrapper" data-fetch-url="{{ route('bolsa.empleados') }}">

                            @include('bolsa.admin.partials.empleados-content')

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



        <div

            id="send-cv-modal"

            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"

            data-send-base-url="{{ url('/bolsa/admin/empleados') }}"

            aria-hidden="true"

        >

            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>

            <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-3xl border border-white/40 bg-white/80 shadow-2xl">

                <div class="flex flex-col gap-6 px-8 py-8">

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Bolsa de trabajo</p>

                            <h2 class="text-2xl font-semibold uppercase tracking-[0.25em] text-slate-900">Enviar CV</h2>

                            <p class="text-[0.65rem] uppercase tracking-[0.3em] text-slate-500">

                                El correo se enviará desde la cuenta configurada en el .env y adjuntará el PDF guardado.

                            </p>

                        </div>

                        <button

                            type="button"

                            data-modal-close

                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-500 bg-white text-sm font-semibold text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"

                            aria-label="Cerrar envío de correo"

                        >

                            ×

                        </button>

                    </div>



                    <form id="send-cv-form" method="POST" action="" class="space-y-5">

                        @csrf

                        <div class="grid gap-4 md:grid-cols-2">

                            <label class="space-y-2">

                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Correo destinatario</span>

                                <input

                                    type="email"

                                    name="destinatario"

                                    class="w-full rounded-2xl border border-slate-500 bg-white/80 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"

                                    placeholder="cliente@dominio.com"

                                    required

                                />

                            </label>

                            <label class="space-y-2">

                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Asunto</span>

                                <input

                                    type="text"

                                    name="asunto"

                                    class="w-full rounded-2xl border border-slate-500 bg-white/80 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"

                                    placeholder="CV candidato"

                                    maxlength="150"

                                    required

                                />

                            </label>

                        </div>

                        <label class="space-y-2 block">

                            <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Contenido</span>

                            <textarea

                                name="mensaje"

                                rows="6"

                                class="w-full rounded-2xl border border-slate-500 bg-white/80 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"

                                placeholder="Mensaje a enviar junto con el CV adjunto"

                                maxlength="2000"

                                required

                            ></textarea>

                        </label>



                        <div

                            data-send-status

                            class="hidden rounded-2xl border px-4 py-3 text-sm"

                        ></div>



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

                                data-send-submit

                                class="rounded-2xl bg-blue-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white shadow-lg transition hover:bg-blue-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-blue-300"

                            >

                                Enviar

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>



        <div

            id="send-cv-confirmation"

            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"

            aria-hidden="true"

        >

            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-confirm-close></div>

            <div class="relative z-10 w-full max-w-md overflow-hidden rounded-3xl border border-white/40 bg-white/90 shadow-2xl">

                <div class="flex flex-col gap-4 px-8 py-8 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full border border-emerald-300 bg-emerald-50 text-emerald-700">

                        ✓

                    </div>

                    <h3 class="text-lg font-semibold uppercase tracking-[0.25em] text-slate-900">Correo enviado</h3>

                    <p class="text-sm text-slate-600">El mensaje y el PDF se enviaron correctamente.</p>

                    <div class="flex justify-center">

                        <button

                            type="button"

                            data-confirm-close

                            class="rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white shadow-lg transition hover:bg-emerald-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-emerald-300"

                        >

                            Cerrar

                        </button>

                    </div>

                </div>

            </div>

        </div>



        <div

            id="send-cv-bulk-modal"

            class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-6"

            data-send-bulk-url="{{ route('bolsa.empleados.sendMultiple') }}"

            aria-hidden="true"

        >

            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-bulk-modal-close></div>

            <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-3xl border border-white/40 bg-white/80 shadow-2xl">

                <div class="flex flex-col gap-6 px-8 py-8">

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Bolsa de trabajo</p>

                            <h2 class="text-2xl font-semibold uppercase tracking-[0.25em] text-slate-900">Enviar CVs seleccionados</h2>

                            <p class="text-[0.65rem] uppercase tracking-[0.3em] text-slate-500">

                                Adjuntaremos todos los PDF seleccionados; usa un mensaje breve para no saturar.

                            </p>

                        </div>

                        <button

                            type="button"

                            data-bulk-modal-close

                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-500 bg-white text-sm font-semibold text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"

                            aria-label="Cerrar envío múltiple"

                        >

                            ×

                        </button>

                    </div>



                    <form id="send-cv-bulk-form" method="POST" action="" class="space-y-5">

                        @csrf

                        <div id="send-cv-bulk-inputs"></div>

                        <div class="grid gap-4 md:grid-cols-2">

                            <label class="space-y-2">

                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Correo destinatario</span>

                                <input

                                    type="email"

                                    name="destinatario"

                                    class="w-full rounded-2xl border border-slate-500 bg-white/80 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"

                                    placeholder="cliente@dominio.com"

                                    required

                                />

                            </label>

                            <label class="space-y-2">

                                <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Asunto</span>

                                <input

                                    type="text"

                                    name="asunto"

                                    class="w-full rounded-2xl border border-slate-500 bg-white/80 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"

                                    placeholder="CVs candidatos"

                                    maxlength="150"

                                    required

                                />

                            </label>

                        </div>

                        <label class="space-y-2 block">

                            <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Contenido</span>

                            <textarea

                                name="mensaje"

                                rows="6"

                                class="w-full rounded-2xl border border-slate-500 bg-white/80 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60"

                                placeholder="Adjunto CVs en PDF de los candidatos seleccionados."

                                maxlength="2000"

                                required

                            ></textarea>

                        </label>



                        <div

                            data-send-bulk-status

                            class="hidden rounded-2xl border px-4 py-3 text-sm"

                        ></div>



                        <div class="flex flex-wrap items-center justify-end gap-3">

                            <button

                                type="button"

                                data-bulk-modal-close

                                class="rounded-2xl border border-slate-500 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-900 transition hover:border-slate-500 hover:bg-slate-100"

                            >

                                Cancelar

                            </button>

                            <button

                                type="submit"

                                data-send-bulk-submit

                                class="rounded-2xl bg-blue-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white shadow-lg transition hover:bg-blue-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-blue-300"

                            >

                                Enviar

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

                let currentPage = 1;



                const updateCurrentPageFromDOM = () => {

                    const list = wrapper.querySelector('#empleados-list');

                    const pageValue = list && list.dataset ? list.dataset.currentPage : null;

                    currentPage = Number(pageValue) || 1;

                };



                updateCurrentPageFromDOM();



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



                const fetchData = async (page = currentPage) => {

                    const params = new URLSearchParams({

                        area: areaSelect.value,

                        subarea: subareaSelect.value,

                        search: searchInput.value,

                        order: orderSelect.value,

                    });



                    if (page > 1) {

                        params.set('page', String(page));

                    } else {

                        params.delete('page');

                    }



                    const response = await fetch(`${fetchUrl}?${params.toString()}`, {

                        headers: {

                            'X-Requested-With': 'XMLHttpRequest',

                        },

                    });

                    const data = await response.json();

                    wrapper.innerHTML = data.content;

                    subareaSelect.innerHTML = data.subareas;

                    toggleSubarea();

                    updateCurrentPageFromDOM();

                    document.dispatchEvent(new CustomEvent('empleados:updated'));

                };



                const handlePaginationClick = (event) => {

                    const button = event.target.closest('[data-pagination-link]');

                    if (!button) {

                        return;

                    }

                    event.preventDefault();

                    const targetPage = Number(button.dataset.page);

                    if (Number.isNaN(targetPage) || targetPage === currentPage) {

                        return;

                    }

                    fetchData(targetPage);

                };



                wrapper.addEventListener('click', handlePaginationClick);



                areaSelect.addEventListener('change', () => {

                    subareaSelect.value = '';

                    fetchData(1);

                });

                subareaSelect.addEventListener('change', () => fetchData(1));

                orderSelect.addEventListener('change', () => fetchData(1));

                form.addEventListener('submit', (event) => {

                    event.preventDefault();

                    fetchData(1);

                });



                let debounce;

                searchInput.addEventListener('input', () => {

                    clearTimeout(debounce);

                    debounce = setTimeout(() => fetchData(1), 400);

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

        <script>

            document.addEventListener('DOMContentLoaded', () => {

                const modal = document.getElementById('send-cv-modal');

                const confirmation = document.getElementById('send-cv-confirmation');

                if (!modal) {

                    return;

                }



                const form = document.getElementById('send-cv-form');

                const destinatarioInput = form.querySelector('[name="destinatario"]');

                const asuntoInput = form.querySelector('[name="asunto"]');

                const mensajeInput = form.querySelector('[name="mensaje"]');

                const statusBox = modal.querySelector('[data-send-status]');

                const submitButton = modal.querySelector('[data-send-submit]');

                const closeElements = modal.querySelectorAll('[data-modal-close]');

                const baseUrl = modal.dataset.sendBaseUrl;

                const csrf = form.querySelector('input[name="_token"]')?.value;

                const confirmCloseElements = confirmation?.querySelectorAll('[data-confirm-close]') || [];



                const setStatus = (message, variant = 'info') => {

                    if (!statusBox) {

                        return;

                    }

                    const variants = {

                        info: 'border-slate-300 bg-slate-50 text-slate-700',

                        success: 'border-emerald-400/70 bg-emerald-50 text-emerald-900',

                        error: 'border-rose-400/70 bg-rose-50 text-rose-900',

                    };

                    statusBox.className = 'rounded-2xl border px-4 py-3 text-sm';

                    statusBox.classList.add(...(variants[variant] || variants.info).split(' '));

                    statusBox.textContent = message;

                    statusBox.classList.remove('hidden');

                };



                const clearStatus = () => {

                    if (statusBox) {

                        statusBox.classList.add('hidden');

                        statusBox.textContent = '';

                    }

                };



                const defaultMessage = (name) => {

                    if (!name) {

                        return 'Adjunto el CV en PDF.';

                    }

                    return `Hola,\nAdjunto el CV en PDF de ${name}.`;

                };



                const openModal = (payload) => {

                    if (!payload || !payload.id) {

                        return;

                    }

                    form.action = `${baseUrl}/${payload.id}/enviar`;

                    destinatarioInput.value = '';

                    asuntoInput.value = payload.nombre ? `CV - ${payload.nombre}` : 'CV candidato';

                    mensajeInput.value = defaultMessage(payload.nombre);

                    modal.classList.remove('hidden');

                    modal.setAttribute('aria-hidden', 'false');

                    document.body.classList.add('overflow-hidden');

                    clearStatus();

                    submitButton.disabled = false;

                    submitButton.textContent = 'Enviar';

                };



                const closeModal = () => {

                    modal.classList.add('hidden');

                    modal.setAttribute('aria-hidden', 'true');

                    document.body.classList.remove('overflow-hidden');

                    form.reset();

                    clearStatus();

                };



                const openConfirmation = () => {

                    if (!confirmation) {

                        return;

                    }

                    confirmation.classList.remove('hidden');

                    confirmation.setAttribute('aria-hidden', 'false');

                };



                const closeConfirmation = () => {

                    if (!confirmation) {

                        return;

                    }

                    confirmation.classList.add('hidden');

                    confirmation.setAttribute('aria-hidden', 'true');

                };



                document.addEventListener('click', (event) => {

                    const button = event.target.closest('[data-send-email-button]');

                    if (!button) {

                        return;

                    }

                    event.preventDefault();

                    const payload = button.dataset.sendPayload ? JSON.parse(button.dataset.sendPayload) : null;

                    openModal(payload);

                });



                if (closeElements.length) {

                    closeElements.forEach((element) => {

                        element.addEventListener('click', (event) => {

                            event.preventDefault();

                            closeModal();

                        });

                    });

                }



                form.addEventListener('submit', async (event) => {

                    event.preventDefault();

                    clearStatus();

                    submitButton.disabled = true;

                    submitButton.textContent = 'Enviando...';



                    try {

                        const response = await fetch(form.action, {

                            method: 'POST',

                            headers: {

                                Accept: 'application/json',

                                'X-Requested-With': 'XMLHttpRequest',

                                ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),

                            },

                            body: new FormData(form),

                        });

                        const data = await response.json().catch(() => ({}));

                        if (!response.ok) {

                            const message = data?.message || 'No se pudo enviar el correo.';

                            setStatus(message, 'error');

                            submitButton.disabled = false;

                            submitButton.textContent = 'Enviar';

                            return;

                        }

                        setStatus(data?.message || 'Correo enviado correctamente.', 'success');

                        closeModal();

                        openConfirmation();

                    } catch (error) {

                        setStatus('Ocurrió un error al enviar el correo.', 'error');

                        submitButton.disabled = false;

                        submitButton.textContent = 'Enviar';

                    }

                });



                document.addEventListener('keydown', (event) => {

                    if (event.key === 'Escape' && !modal.classList.contains('hidden')) {

                        closeModal();

                    }

                    if (event.key === 'Escape' && confirmation && !confirmation.classList.contains('hidden')) {

                        closeConfirmation();

                    }

                });



                if (confirmCloseElements.length) {

                    confirmCloseElements.forEach((element) => {

                        element.addEventListener('click', (event) => {

                            event.preventDefault();

                            closeConfirmation();

                        });

                    });

                }

            });

        </script>

    

        <script>

            document.addEventListener('DOMContentLoaded', () => {

                const wrapper = document.getElementById('empleados-wrapper');

                const bulkStart = document.getElementById('bulk-start');

                const bulkActions = document.getElementById('bulk-actions');

                const bulkCancel = document.getElementById('bulk-cancel');

                const bulkConfirm = document.getElementById('bulk-confirm');

                const bulkCount = document.getElementById('bulk-count');

                const bulkModal = document.getElementById('send-cv-bulk-modal');

                const bulkForm = document.getElementById('send-cv-bulk-form');

                const bulkInputs = document.getElementById('send-cv-bulk-inputs');

                const bulkStatus = bulkModal?.querySelector('[data-send-bulk-status]');

                const bulkSubmit = bulkModal?.querySelector('[data-send-bulk-submit]');

                const bulkCloseElements = bulkModal?.querySelectorAll('[data-bulk-modal-close]') || [];

                const bulkUrl = bulkModal?.dataset.sendBulkUrl;

                const confirmation = document.getElementById('send-cv-confirmation');

                const confirmCloseElements = confirmation?.querySelectorAll('[data-confirm-close]') || [];

                const csrf = bulkForm?.querySelector('input[name="_token"]')?.value;



                if (!wrapper || !bulkStart || !bulkActions || !bulkModal || !bulkForm) {

                    return;

                }



                let bulkMode = false;

                const selected = new Set();



                const setStatus = (message, variant = 'info') => {

                    if (!bulkStatus) {

                        return;

                    }

                    const variants = {

                        info: 'border-slate-300 bg-slate-50 text-slate-700',

                        success: 'border-emerald-400/70 bg-emerald-50 text-emerald-900',

                        error: 'border-rose-400/70 bg-rose-50 text-rose-900',

                    };

                    bulkStatus.className = 'rounded-2xl border px-4 py-3 text-sm';

                    bulkStatus.classList.add(...(variants[variant] || variants.info).split(' '));

                    bulkStatus.textContent = message;

                    bulkStatus.classList.remove('hidden');

                };



                const clearStatus = () => {

                    if (bulkStatus) {

                        bulkStatus.classList.add('hidden');

                        bulkStatus.textContent = '';

                    }

                };



                const updateCount = () => {

                    if (!bulkCount) {

                        return;

                    }

                    bulkCount.textContent = selected.size ? `${selected.size} seleccionados` : 'Nada seleccionado';

                    if (bulkSubmit) {

                        bulkSubmit.disabled = selected.size === 0;

                    }

                };



                const renderCheckboxes = () => {

                    const toggles = wrapper.querySelectorAll('[data-bulk-toggle]');

                    toggles.forEach((label) => label.classList.toggle('hidden', !bulkMode));

                    const checkboxes = wrapper.querySelectorAll('[data-bulk-checkbox]');

                    checkboxes.forEach((checkbox) => {

                        checkbox.checked = selected.has(checkbox.value);

                    });

                    updateCount();

                };



                const startBulk = () => {

                    bulkMode = true;

                    bulkStart.classList.add('hidden');

                    bulkActions.classList.remove('hidden');

                    renderCheckboxes();

                };



                const resetBulk = () => {

                    bulkMode = false;

                    selected.clear();

                    bulkActions.classList.add('hidden');

                    bulkStart.classList.remove('hidden');

                    renderCheckboxes();

                };



                const openBulkModal = () => {

                    if (selected.size === 0 || !bulkUrl) {

                        setStatus('Selecciona al menos un registro.', 'error');

                        return;

                    }

                    if (bulkInputs) {

                        bulkInputs.innerHTML = '';

                        selected.forEach((id) => {

                            const input = document.createElement('input');

                            input.type = 'hidden';

                            input.name = 'empleados[]';

                            input.value = id;

                            bulkInputs.appendChild(input);

                        });

                    }

                    const subjectInput = bulkForm.querySelector('[name="asunto"]');

                    const messageInput = bulkForm.querySelector('[name="mensaje"]');

                    const destinatarioInput = bulkForm.querySelector('[name="destinatario"]');

                    if (subjectInput) {

                        subjectInput.value = `CVs candidatos (${selected.size})`;

                    }

                    if (messageInput) {

                        const noun = selected.size === 1 ? 'el CV en PDF' : 'los CVs en PDF';

                        messageInput.value = `Adjunto ${noun} de los candidatos seleccionados.`;

                    }

                    if (destinatarioInput) {

                        destinatarioInput.value = '';

                    }

                    bulkForm.action = bulkUrl;

                    bulkModal.classList.remove('hidden');

                    bulkModal.setAttribute('aria-hidden', 'false');

                    document.body.classList.add('overflow-hidden');

                    clearStatus();

                    if (bulkSubmit) {

                        bulkSubmit.disabled = false;

                        bulkSubmit.textContent = 'Enviar';

                    }

                };



                const closeBulkModal = () => {

                    bulkModal.classList.add('hidden');

                    bulkModal.setAttribute('aria-hidden', 'true');

                    document.body.classList.remove('overflow-hidden');

                    bulkForm.reset();

                    if (bulkInputs) {

                        bulkInputs.innerHTML = '';

                    }

                    clearStatus();

                };



                const openConfirmation = () => {

                    if (!confirmation) {

                        return;

                    }

                    confirmation.classList.remove('hidden');

                    confirmation.setAttribute('aria-hidden', 'false');

                };



                const closeConfirmation = () => {

                    if (!confirmation) {

                        return;

                    }

                    confirmation.classList.add('hidden');

                    confirmation.setAttribute('aria-hidden', 'true');

                };



                bulkStart.addEventListener('click', (event) => {

                    event.preventDefault();

                    startBulk();

                });



                bulkCancel?.addEventListener('click', (event) => {

                    event.preventDefault();

                    resetBulk();

                });



                bulkConfirm?.addEventListener('click', (event) => {

                    event.preventDefault();

                    if (!bulkMode) {

                        startBulk();

                        return;

                    }

                    if (selected.size === 0) {

                        setStatus('Selecciona al menos un registro.', 'error');

                        if (bulkCount) {

                            bulkCount.textContent = 'Selecciona al menos un registro';

                        }

                        return;

                    }

                    openBulkModal();

                });



                wrapper.addEventListener('change', (event) => {

                    const checkbox = event.target.closest('[data-bulk-checkbox]');

                    if (!checkbox) {

                        return;

                    }

                    if (!bulkMode) {

                        checkbox.checked = false;

                        return;

                    }

                    const id = checkbox.value;

                    if (checkbox.checked) {

                        selected.add(id);

                    } else {

                        selected.delete(id);

                    }

                    updateCount();

                });



                document.addEventListener('empleados:updated', () => {

                    renderCheckboxes();

                });



                if (bulkCloseElements.length) {

                    bulkCloseElements.forEach((element) => {

                        element.addEventListener('click', (event) => {

                            event.preventDefault();

                            closeBulkModal();

                        });

                    });

                }



                if (confirmCloseElements.length) {

                    confirmCloseElements.forEach((element) => {

                        element.addEventListener('click', (event) => {

                            event.preventDefault();

                            closeConfirmation();

                        });

                    });

                }



                bulkForm.addEventListener('submit', async (event) => {

                    event.preventDefault();

                    if (selected.size === 0) {

                        setStatus('Selecciona al menos un registro.', 'error');

                        return;

                    }

                    clearStatus();

                    if (bulkSubmit) {

                        bulkSubmit.disabled = true;

                        bulkSubmit.textContent = 'Enviando...';

                    }

                    try {

                        const formData = new FormData(bulkForm);

                        const response = await fetch(bulkUrl, {

                            method: 'POST',

                            headers: {

                                Accept: 'application/json',

                                'X-Requested-With': 'XMLHttpRequest',

                                ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),

                            },

                            body: formData,

                        });

                        const data = await response.json().catch(() => ({}));

                        if (!response.ok) {

                            const message = data?.message || 'No se pudo enviar el correo.';

                            setStatus(message, 'error');

                            if (bulkSubmit) {

                                bulkSubmit.disabled = false;

                                bulkSubmit.textContent = 'Enviar';

                            }

                            return;

                        }

                        setStatus(data?.message || 'Correos enviados correctamente.', 'success');

                        closeBulkModal();

                        resetBulk();

                        openConfirmation();

                    } catch (error) {

                        setStatus('Ocurrió un error al enviar los correos.', 'error');

                        if (bulkSubmit) {

                            bulkSubmit.disabled = false;

                            bulkSubmit.textContent = 'Enviar';

                        }

                    }

                });



                document.addEventListener('keydown', (event) => {

                    if (event.key === 'Escape' && bulkMode) {

                        resetBulk();

                    }

                    if (event.key === 'Escape' && !bulkModal.classList.contains('hidden')) {

                        closeBulkModal();

                    }

                });



                renderCheckboxes();

            });

        </script>



    </body>

</html>





