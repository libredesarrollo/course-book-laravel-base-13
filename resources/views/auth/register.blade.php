@extends('auth.layout')

@section('content')
    <h1>Register</h1>

    <!-- Mostrar errores de validación -->
    @include('dashboard.fragment._errors')

    <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-2">
        @csrf

        <div>
            <label class="form-label" for="name">Name</label>
            <input class="form-input" type="name" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label class="form-label" for="email">Email</label>
            <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label class="form-label" for="password">Password</label>
            <input class="form-input" type="password" id="password" name="password" required>
        </div>
        <div>
            <label class="form-label" for="password">Password Confirmation</label>
            <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="flex flex-row-reverse">
            <button type="submit" class="btn btn-primary">
                Register
            </button>
        </div>
    </form>

@endsection
