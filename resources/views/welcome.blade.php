<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - Presentación</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *,
            :before,
            :after,
            ::backdrop {
                --tw-border-style: solid;
                --tw-font-weight: initial;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-color: initial;
                --tw-shadow-alpha: 100%;
                --tw-inset-shadow: 0 0 #0000;
                --tw-inset-shadow-color: initial;
                --tw-inset-shadow-alpha: 100%;
                --tw-ring-color: initial;
                --tw-ring-shadow: 0 0 #0000;
                --tw-inset-ring-color: initial;
                --tw-inset-ring-shadow: 0 0 #0000
            }

            html,
            :host {
                line-height: 1.5;
                -webkit-text-size-adjust: 100%;
                tab-size: 4;
                font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-feature-settings: normal;
                font-variation-settings: normal;
                -webkit-tap-highlight-color: transparent
            }

            body {
                margin: 0;
                line-height: inherit
            }
        </style>
    @endif
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">
    <header class="w-full max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC]">
            {{ config('app.name', 'Laravel') }}
        </a>

        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard/post') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="flex-1 max-w-6xl mx-auto px-6 py-12 w-full">
        {{-- Hero --}}
        <section class="text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                {{ config('app.name', 'Laravel') }}
            </h1>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] max-w-2xl mx-auto">
                Proyecto de presentación con módulo administrativo, blog público y ejemplos prácticos de Laravel 13.
            </p>

            <ul class="text-[#706f6c] dark:text-[#A1A09A]">
                <li>User: admin@admin.com</li>
                <li>Pass: !a5qRNEtVXyX3s</li>
            </ul>

        </section>

        {{-- Modulos Principales --}}
        <section class="mb-16">
            <h2 class="text-2xl font-semibold mb-6 text-[#1b1b18] dark:text-[#EDEDEC]">Módulos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Dashboard --}}
                <a href="{{ url('/dashboard/post') }}"
                    class="group block p-6 bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl">⚙️</span>
                        <h3
                            class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#f53003] dark:group-hover:text-[#FF4433] transition-colors">
                            Dashboard
                        </h3>
                    </div>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Administración de Posts, Categorías, Usuarios, Roles y Permisos. Acceso exclusivo para
                        administradores.
                    </p>
                    @auth
                        <span class="inline-block mt-3 text-xs font-medium text-[#f53003] dark:text-[#FF4433]">Ir al
                            Dashboard &rarr;</span>
                    @else
                        <span class="inline-block mt-3 text-xs font-medium text-[#706f6c] dark:text-[#A1A09A]">Inicia sesión
                            para acceder &rarr;</span>
                    @endauth
                </a>

                {{-- Blog --}}
                <a href="{{ route('blog.index') }}"
                    class="group block p-6 bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl">📝</span>
                        <h3
                            class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#f53003] dark:group-hover:text-[#FF4433] transition-colors">
                            Blog
                        </h3>
                    </div>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Blog público con vistas de listado y detalle de posts. Consume los datos gestionados desde el
                        Dashboard.
                    </p>
                    <span class="inline-block mt-3 text-xs font-medium text-[#f53003] dark:text-[#FF4433]">Visitar Blog
                        &rarr;</span>
                </a>
            </div>
        </section>

        {{-- Ejemplos --}}
        <section>
            <h2 class="text-2xl font-semibold mb-6 text-[#1b1b18] dark:text-[#EDEDEC]">Ejemplos y Pruebas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Blade --}}
                <a href="{{ url('/blade') }}"
                    class="group block p-5 bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] hover:shadow-md transition-shadow">
                    <h4
                        class="font-medium text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#f53003] dark:group-hover:text-[#FF4433] transition-colors">
                        Blade</h4>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">Ejemplos de directivas Blade y layouts
                    </p>
                </a>

                {{-- Vue --}}
                <a href="{{ url('/vue') }}"
                    class="group block p-5 bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] hover:shadow-md transition-shadow">
                    <h4
                        class="font-medium text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#f53003] dark:group-hover:text-[#FF4433] transition-colors">
                        Vue</h4>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">Componente Vue 3 con parámetros
                        opcionales</p>
                </a>

                {{-- Jobs / Queue --}}
                <a href="{{ url('/test-job') }}"
                    class="group block p-5 bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] hover:shadow-md transition-shadow">
                    <h4
                        class="font-medium text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#f53003] dark:group-hover:text-[#FF4433] transition-colors">
                        Jobs & Queue</h4>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">Prueba de encolamiento de trabajos</p>
                </a>

                {{-- Profile --}}
                <a href="{{ route('profile.edit') }}"
                    class="group block p-5 bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] hover:shadow-md transition-shadow">
                    <h4
                        class="font-medium text-[#1b1b18] dark:text-[#EDEDEC] group-hover:text-[#f53003] dark:group-hover:text-[#FF4433] transition-colors">
                        Perfil</h4>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">Edición de perfil de usuario</p>
                </a>




            </div>
        </section>
    </main>

    <footer
        class="max-w-6xl mx-auto px-6 py-6 border-t border-[#e3e3e0] dark:border-[#3E3E3A] text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
        <p>{{ config('app.name', 'Laravel') }} &mdash; v{{ app()->version() }}</p>
    </footer>
</body>

</html>
