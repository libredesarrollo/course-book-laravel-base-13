@extends('dashboard.layout')

@section('content')
    
    @include('dashboard.fragment._errors')
    
    <form action="{{ route('category.store') }}" method="POST">
        @csrf
        
        <label for="title">Title</label>
        <input type="text" name="title" value="{{ old('title', $category->title) }}">

        <label for="slug">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}">

        <button type="submit">Enviar</button>
    </form>
@endsection