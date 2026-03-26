@extends('dashboard.layout')

@section('content')

    @include('dashboard.fragment._errors')

   <form action="{{ route('role.store') }}" method="post">
        @include('dashboard.role._form')
   </form>
@endsection