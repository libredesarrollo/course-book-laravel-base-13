<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Plataforma Educativa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-slate-50 p-10">

    <header class="mb-5 p-4 bg-white shadow">
        {{-- Directiva de Autenticación --}}

        {{-- prueba traducciones --}}
        <p>{{ __('welcome.welcome') }}</p>
        <p>{{ __('welcome.welcome_by',['name' => 'andrew']) }}</p>

        @auth
            <p>Conectado como: <strong>@yield('user_name')</strong></p>
        @endauth
    </header>

    <main class="container mx-auto">
        @yield('content')
    </main>

    {{-- Directiva para inyectar scripts desde vistas hijas --}}
    @stack('scripts')
</body>
</html>