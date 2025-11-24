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
        @include('bolsa.partials.header-registro')

        <main class="flex flex-1 flex-col pt-20 pb-12">
            <section class="mx-auto w-full max-w-xl px-6 py-14">
                <div class="relative rounded-3xl border border-white/60 bg-slate-50/90 p-0 overflow-hidden shadow-2xl shadow-black/80 text-slate-900 backdrop-blur-3xl">
                    <div class="bg-red-600/90 border-b border-red-500/40 px-6 py-4 text-center text-xs uppercase tracking-[0.4em] font-semibold text-white">
                        INICIA SESION
                    </div>
                    <div class="space-y-10 px-10 py-8">

                        @if ($errors->any())
                            <div class="rounded-2xl border border-red-500/70 bg-red-500/10 px-5 py-3 text-sm text-red-100">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('bolsa.login') }}" method="POST" class="space-y-8 max-w-sm mx-auto">
                            @csrf

                            <label class="space-y-2">
                                <span class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-slate-600">Correo</span>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    required
                                    autofocus
                                    value="{{ old('email') }}"
                                    placeholder="correo@dominio.com"
                                    class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                />
                            </label>

                            <label class="space-y-2">
                                <span class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-slate-600">Contraseña</span>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    required
                                    placeholder="••••••••••••••"
                                    class="w-full rounded-2xl border border-slate-400 bg-white/50 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-500 focus:border-slate-900/60 focus:outline-none focus:ring-2 focus:ring-slate-300/60 transition"
                                />
                            </label>

                            <button
                                type="submit"
                                class="w-full rounded-2xl bg-red-600 px-4 py-3 text-xs font-semibold uppercase tracking-[0.4em] text-white shadow-lg transition hover:bg-red-500 focus-visible:outline-none focus-visible:ring focus-visible:ring-red-300 mt-4"
                            >
                                Entrar
                            </button>
                        </form>

                    </div>
                </div>
            </section>
        </main>

        @include('bolsa.partials.footer-registro')
    </body>
</html>
