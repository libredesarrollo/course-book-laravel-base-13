@props(['title' => 'Default title', 'posts'])

<div class="container mx-auto px-4 py-12">
    <header class="mb-12 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">{{ $title }}</h1>
        
        @isset($header)
            <div class="text-lg text-gray-600 mb-4">{{ $header }}</div>
        @endisset

        @if($slot->isNotEmpty())
            <div class="max-w-2xl mx-auto text-gray-500">{{ $slot }}</div>
        @endif
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($posts as $p)
            <article class="card">
                <div class="p-6 flex-1">
                    <div class="text-sm text-gray-400 mb-2">{{ $p->created_at->diffForHumans() }}</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        {{ $p->title }}
                    </h3>
                    <p class="text-gray-600 line-clamp-3 leading-relaxed">{{ $p->description }}</p>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <a href="{{ route('blog.show', $p) }}" class="text-blue-600 font-semibold text-sm hover:underline">Leer artículo &rarr;</a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $posts->links() }}
    </div>
</div>
