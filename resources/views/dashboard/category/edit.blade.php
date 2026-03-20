@extends('dashboard.layout')

@section('content')
    @include('dashboard.fragment._errors')

    <form action="{{ route('category.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Title</label>
        <input type="text" name="title" value="{{ old('title', $category->title) }}">

        <label for="slug">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}">

        <button type="submit">Actualizar</button>
    </form>
@endsection
