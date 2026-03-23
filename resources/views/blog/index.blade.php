@extends('blog.layout')

@section('content')
    <x-blog.post.index :posts="$posts" />
@endsection