@extends('auth.layout')

@section('content')
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Register</h1>

    <!-- Mostrar errores de validación -->
    @include('dashboard.fragment._errors')

    <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
        @csrf

        <div>
            <label class="form-label" for="name">Name</label>
            <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}">
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
            <label class="form-label" for="password_confirmation">Password Confirmation</label>
            <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit" class="btn btn-primary">
                Register
            </button>
        </div>
    </form>

@endsection
