<div>
    @isset($changeTitle)
        {{ $changeTitle() }}
    @endisset
    {{ $post->title }}

</div>