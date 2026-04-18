<div class="card">
  
        {{-- {{ $changeTitle() }} --}}
        <h1>{{ $post->title }}</h1>



    <header class="mb-8 border-b border-gray-100 pb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>
        <div class="text-sm text-gray-500">
            Publicado el {{ $post->created_at->format('d M, Y') }}
        </div>
    </header>

    <p class="text-xl text-gray-600 italic mb-8 leading-relaxed">{{ $post->description }}</p>

    <div class="max-w-none text-gray-800">
        {{ $post->content }}
    </div>
</div>
