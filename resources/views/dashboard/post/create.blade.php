@extends('dashboard.layout')

@section('content')
    @include('dashboard.fragment._errors')

    <form id="myForm" action="{{ route('post.store') }}" method="post">
        @include('dashboard.post._form')
    </form>
@endsection
