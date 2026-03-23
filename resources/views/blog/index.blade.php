@extends('blog.layout')



@section('content')

    {{-- <x-blog.post.index :posts="$posts" /> --}}
    <x-blog.post.index :posts="$posts" title='List' >
        POST LIST - SLOT POR DEFECTO
        @slot('header')
            <h2>MY HEADER PERSONALIZADO PORT SLOT</h2>
        @endslot
    </x-blog.post.index>

@endsection