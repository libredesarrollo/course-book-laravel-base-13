@extends('blog.layout')

@section('content')
    <x-blog.post.show :post="$post" />
    <x-blog.post.detail :post="$post"/>
@endsection