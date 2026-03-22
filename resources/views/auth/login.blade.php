@extends('auth.layout')

@section('content')
    <h1>Login</h1>

    @include('dashboard.fragment._errors')

    <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-2">
        @csrf

        <div>
            <label class="form-label" for="email">Email</label>
            <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label class="form-label" for="password">Password</label>
            <input class="form-input" type="password" id="password" name="password" required>
        </div>

          <div class="flex flex-row-reverse">
            <button type="submit" class="btn btn-primary">
                Log in
            </button>
        </div>
    </form>
@endsection
