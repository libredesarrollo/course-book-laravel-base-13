

<h1>{{ $post->title }}</h1>
<p>{{ $post->description }}</p>

<div>{{ $post->content }}</div>

@if ($post->image)
    <img src="/image/{{ $post->image }}" alt="">
@endif