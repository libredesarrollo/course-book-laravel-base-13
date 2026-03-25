@extends('pruebas.layout')

@section('title', 'Panel de Control - Blade 13')
@section('user_name', $user)

@section('content')
    <h1 class="text-2xl font-bold mb-6">Explorando Directivas de Blade</h1>

    {{-- 1. Condicionales If / Else --}}
    <section class="mb-8">
        <h2 class="text-lg font-semibold">Estado de la cuenta:</h2>
        @if($status === 1)
            <span class="text-yellow-600">Esperando verificación...</span>
        @elseif($status === 2)
            <span class="text-green-600">Cuenta verificada correctamente.</span>
        @else
            <span class="text-red-600">Cuenta restringida.</span>
        @endif
    </section>

    {{-- 2. Directiva Switch --}}
    <section class="mb-8">
        @switch($role)
            @case('admin')
                <div class="bg-blue-100 p-2 text-blue-800">Acceso total de administrador</div>
                @break
            @case('editor')
                <div class="bg-green-100 p-2 text-green-800">Acceso de edición</div>
                @break
            @default
                <div class="bg-gray-100 p-2">Acceso de lectura</div>
        @endswitch
    </section>

    {{-- 3. Bucles y la variable $loop --}}
    <section class="mb-8">
        <h2 class="text-xl font-bold mb-3">Listado de Cursos</h2>
        <ul class="space-y-2">
            @foreach($courses as $course)
                <li @class([
                    'p-3 rounded border',
                    'bg-yellow-50 border-yellow-200' => $course['premium'],
                    'bg-white border-gray-200' => !$course['premium']
                ])>
                    <strong>#{{ $loop->iteration }}</strong> - {{ $course['name'] }} 
                    <span class="text-sm italic">({{ $course['type'] }})</span>

                    @if($loop->first) <b class="text-blue-500">[NUEVO]</b> @endif
                    @if($loop->last) <b class="text-gray-400">[FINAL]</b> @endif
                </li>
            @endforeach
        </ul>
    </section>

    {{-- 4. Forelse (Manejo de estados vacíos) --}}
    <section class="mb-8">
        <h2 class="text-lg font-semibold">Etiquetas del perfil:</h2>
        <div class="flex gap-2">
            @forelse($tags as $tag)
                <span class="bg-gray-200 px-2 py-1">{{ $tag }}</span>
            @empty
                <p class="text-gray-400 italic">No has definido etiquetas todavía.</p>
            @endforelse
        </div>
    </section>

    {{-- 5. Directivas de Sesión y Errores (Útiles en formularios) --}}
    <section class="mb-8 border-t pt-4">
        @error('email')
            <div class="text-red-500 font-bold">Error en el correo: {{ $message }}</div>
        @enderror

        {{-- Directiva de entorno --}}
        @env('local')
            <div class="text-xs text-orange-400 mt-4 italic">
                * Estás viendo esto porque el entorno es Local.
            </div>
        @endenv
    </section>
    {{-- 7. No toques nada de lo que hay aquí dentro, ignora las llaves {{ }} y déjalas tal cual --}}    
    @verbatim
        <div id="app">
            <h1>Perfil de Usuario</h1>
            <p>Nombre: {{ user.name }}</p>
            <p>Email: {{ user.email }}</p>
            <p>Bio: {{ user.bio }}</p>
        </div>
    @endverbatim
            Hola, @{{ nombre_en_js }}.
            Tu edad es @{{ edad_en_js }}.
            Tu ciudad es @{{ ciudad_en_js }}.

    {{-- 8. PHP nativo (Solo cuando es estrictamente necesario) --}}
    @php
        $currentTime = now()->format('H:i');
    @endphp
    <p class="mt-10 text-xs">Generado a las: {{ $currentTime }}</p>

    @foreach($courses as $c)
        <div>
            <h3>{{ $c['name'] }}</h3>
            <canvas id="grafico-{{ $c['id'] }}"></canvas>
        </div>

        {{-- Usamos ONCE para que el script de la librería no se repita 100 veces --}}
        @once
            @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    console.log("La librería Chart.js se cargó solo una vez.");
                </script>
            @endpush
        @endonce

        {{-- Este PUSH no tiene ONCE porque cada gráfico sí necesita su propia inicialización --}}
        @push('scripts')
            <script>
                new Chart(document.getElementById('grafico-{{ $c["id"] }}'), { ... });
            </script>
        @endpush
    @endforeach

@endsection

@push('scripts')
    <script>
        console.log('Blade ha renderizado la vista correctamente.');
    </script>
@endpush

