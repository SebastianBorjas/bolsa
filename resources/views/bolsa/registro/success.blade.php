<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Registro completado - Bolsa</title>
        <link rel="icon" href="{{ asset('images/logos/lgo.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-white text-slate-900 font-sans">
        @include('bolsa.partials.header-registro')

        <main class="flex flex-1 flex-col items-center justify-center pt-32 pb-10">
            <section class="w-full max-w-4xl px-6">
                <div class="rounded-3xl border border-slate-400 bg-slate-50/90 shadow-2xl shadow-black/30 transition">
                    <div class="px-8 py-12 text-center space-y-5">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Bolsa</p>
                        <h1 class="text-4xl font-semibold tracking-[0.3em] text-slate-900">Registro completo</h1>
                        <p class="text-sm text-slate-600">
                            Gracias por enviar tu información. Nuestro equipo revisará tu solicitud y te notificará por correo electrónico cuando surja una oportunidad que se ajuste a tu perfil.
                        </p>
                    </div>
                </div>
            </section>
        </main>

        @include('bolsa.partials.footer-registro')
    </body>
</html>
