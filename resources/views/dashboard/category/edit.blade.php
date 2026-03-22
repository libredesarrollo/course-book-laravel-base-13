@extends('dashboard.layout')

@section('content')
    @include('dashboard.fragment._errors')

    <form action="{{ route('category.update', $category) }}" method="POST" class="grid grid-cols-2 gap-3">
        @csrf
        @method('PUT')
        <div>
            <label class="form-label" for="title">Title</label>
            <input type="text" class="form-input" name="title" value="{{ old('title', $category->title) }}">
        </div>

        <div>
            <label class="form-label" for="slug">Slug</label>
            <input type="text" class="form-input" name="slug" value="{{ old('slug', $category->slug) }}">
        </div>
        <div class="flex">
            <button class="btn btn-primary mt-3" type="submit">Send</button>
        </div>
    </form>
@endsection
