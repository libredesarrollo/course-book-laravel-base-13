@extends('dashboard.layout')

@section('content')
    @include('dashboard.fragment._errors')

    <form action="{{ route('post.store') }}" method="post">
        @include('dashboard.post._form')
    </form>
@endsection
