<header class="relative fixed inset-x-0 top-0 z-50 border-b border-blue-900/60 bg-blue-950/90 backdrop-blur-sm">
    <div class="relative mx-auto flex max-w-6xl flex-col px-6 py-3">
        <div class="flex w-full items-center justify-between gap-3">
            <a href="{{ route('bolsa.index') }}" class="flex items-center gap-3">
                <img
                    src="{{ asset('images/logos/Logo-Bco.png') }}"
                    alt="Logo Bolsa"
                    class="h-10 w-auto object-contain"
                />
                <span class="text-xs font-semibold uppercase tracking-[0.4em] text-white hidden md:inline-flex">Panel administrativo</span>
            </a>
            <div class="hidden items-center gap-3 md:flex">
                <nav class="flex flex-wrap items-center gap-3 md:gap-4">
                    <a
                        href="{{ route('bolsa.index') }}"
                        class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                    >
                        Inicio
                    </a>
                    <a
                        href="{{ route('bolsa.areas') }}"
                        class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                    >
                        Áreas
                    </a>
                    <a
                        href="{{ route('bolsa.sugerencias') }}"
                        class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                    >
                        Sugerencias
                    </a>
                </nav>
                <form action="{{ route('bolsa.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-full border border-white/30 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                    >
                        Cerrar sesión
                    </button>
                </form>
            </div>
            <button
                id="admin-nav-toggle"
                type="button"
                aria-controls="admin-nav-menu"
                aria-expanded="false"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/40 bg-white/10 text-white transition hover:bg-white/20 md:hidden"
            >
                <span class="sr-only">Abrir navegación</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"></path>
                </svg>
            </button>
        </div>
        <div
            id="admin-nav-menu"
            class="absolute inset-x-6 top-full mt-3 hidden flex-col gap-3 rounded-3xl border border-white/30 bg-blue-950 p-4 text-center shadow-lg md:hidden"
        >
            <nav class="flex flex-col gap-3">
                <a
                    href="{{ route('bolsa.index') }}"
                    class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                >
                    Inicio
                </a>
                <a
                    href="{{ route('bolsa.areas') }}"
                    class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                >
                    Áreas
                </a>
                <a
                    href="{{ route('bolsa.sugerencias') }}"
                    class="rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                >
                    Sugerencias
                </a>
            </nav>
            <form action="{{ route('bolsa.logout') }}" method="POST" class="m-0">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-full border border-white/30 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-white transition hover:border-white hover:bg-white/20"
                >
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('admin-nav-toggle');
        const menu = document.getElementById('admin-nav-menu');
        if (!toggle || !menu) {
            return;
        }
        toggle.addEventListener('click', () => {
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !isHidden);
            toggle.setAttribute('aria-expanded', String(isHidden));
        });
        document.addEventListener('click', (event) => {
            if (menu.classList.contains('hidden')) {
                return;
            }
            if (toggle.contains(event.target) || menu.contains(event.target)) {
                return;
            }
            menu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        });
    });
</script>
