<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    {{-- navbar --}}
    <nav class="bg-white border-b border-gray-200 mb-4">
        <div class="container h-16 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="/" class="text-xl font-bold text-gray-800">Dashboard</a>
                <a href="{{ route('post.index') }}"
                    class="text-sm font-medium {{ request()->routeIs('post.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">Posts</a>
                <a href="{{ route('category.index') }}"
                    class="text-sm font-medium {{ request()->routeIs('category.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">Categorías</a>
            </div>

            <div class="relative group">
                <button
                    class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none">
                    {{ auth()->user()->name ?? 'Usuario' }}
                    <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="absolute right-0 top-full hidden w-48 pt-2 group-hover:block group-focus-within:block z-10">
                    <div class="bg-white border border-gray-200 rounded-md shadow-lg py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    {{-- navbar --}}

    <div class="container">

        @if (session('status'))
            <div class="status-box max-w-xl ml-2 my-3">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <div class="card">
            @yield('content')
        </div>
    </div>
</body>

</html>
