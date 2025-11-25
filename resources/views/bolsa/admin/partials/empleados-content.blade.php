@php
    $paginator = $empleados instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $empleados : null;
    $currentPage = $paginator ? $paginator->currentPage() : 1;
    $totalPages = $paginator ? $paginator->lastPage() : 1;
@endphp

<div id="empleados-list" data-current-page="{{ $currentPage }}" data-total-pages="{{ $totalPages }}">
    @include('bolsa.admin.partials.empleados-table')

    <div class="mt-6 flex flex-col gap-3 rounded-2xl border-t border-slate-300/60 pt-5 text-[0.7rem] uppercase tracking-[0.3em] text-slate-500 sm:flex-row sm:items-center sm:justify-between">
        <p>
            Mostrando
            {{ $paginator ? ($paginator->firstItem() ?? 0) : 0 }}
            -
            {{ $paginator ? ($paginator->lastItem() ?? 0) : $empleados->count() }}
            de
            {{ $paginator ? $paginator->total() : $empleados->count() }}
            registros
        </p>

        @if ($paginator && $paginator->hasPages())
            <nav class="flex items-center gap-3" aria-label="Paginación de registros">
                <button
                    type="button"
                    class="rounded-full border border-slate-500 bg-white px-4 py-2 text-[0.65rem] font-semibold tracking-[0.3em] text-slate-900 transition hover:border-slate-400 hover:bg-slate-100 disabled:border-slate-300 disabled:text-slate-400 disabled:hover:border-slate-300"
                    data-pagination-link
                    data-page="{{ max($currentPage - 1, 1) }}"
                    aria-label="Página anterior"
                    @disabled($paginator->onFirstPage())
                >
                    Anterior
                </button>
                <span class="text-[0.65rem] font-semibold tracking-[0.3em] text-slate-500">
                    Página {{ $currentPage }} de {{ $totalPages }}
                </span>
                <button
                    type="button"
                    class="rounded-full border border-slate-500 bg-white px-4 py-2 text-[0.65rem] font-semibold tracking-[0.3em] text-slate-900 transition hover:border-slate-400 hover:bg-slate-100 disabled:border-slate-300 disabled:text-slate-400 disabled:hover:border-slate-300"
                    data-pagination-link
                    data-page="{{ min($currentPage + 1, $totalPages) }}"
                    aria-label="Página siguiente"
                    @disabled($currentPage === $totalPages)
                >
                    Siguiente
                </button>
            </nav>
        @endif
    </div>
</div>
