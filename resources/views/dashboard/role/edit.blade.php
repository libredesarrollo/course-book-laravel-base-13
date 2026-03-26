@extends('dashboard.layout')

@section('content')

    @include('dashboard.fragment._errors')

   <form action="{{ route('role.update', $role->id) }}" method="post">
        @method('PATCH')
        @include('dashboard.role._form', [ 'task'=>'edit' ])
   </form>
@endsection