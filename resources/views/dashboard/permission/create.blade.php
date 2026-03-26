@extends('dashboard.layout')

@section('content')

    @include('dashboard.fragment._errors')

   <form action="{{ route('permission.store') }}" method="post">
        @include('dashboard.permission._form')
   </form>
@endsection