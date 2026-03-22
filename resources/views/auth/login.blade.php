@extends('auth.layout')

@section('content')
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h1>

    @include('dashboard.fragment._errors')

    <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
        @csrf

        <div>
            <label class="form-label" for="email">Email</label>
            <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label class="form-label" for="password">Password</label>
            <input class="form-input" type="password" id="password" name="password" required>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('register') }}">
                Create an account
            </a>

            <button type="submit" class="btn btn-primary">
                Log in
            </button>
        </div>
    </form>
@endsection
