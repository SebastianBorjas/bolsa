<header class="fixed inset-x-0 top-0 z-50 border-b border-blue-900/60 bg-blue-950/90 backdrop-blur-sm">
    <div class="relative mx-auto flex max-w-6xl items-center px-6 py-3">
        <div class="absolute left-6 top-2 hidden items-center gap-3 md:flex">
            <img
                src="{{ asset('images/logos/Logo-Bco.png') }}"
                alt="Logo Bolsa"
                class="h-12 w-auto object-contain"
            />
        </div>
        <div class="flex flex-1 justify-center gap-3 md:gap-4">
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
        </div>
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
</header>
