@extends('auth.layout')

@section('content')
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-3">
        @csrf
        @method('PATCH')

        <!-- Avatar Actual y Input -->
        <div>
            <div>
                <label for="avatar" class="form-label">Avatar</label>

                @if (auth()->user()->profile && auth()->user()->profile->avatar)
                    <div class="mt-2 mb-4">
                        <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="Avatar"
                            class="w-20 h-20 rounded-full object-cover border">
                    </div>
                @endif
                <input id="avatar" name="avatar" type="file"
                    class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />

                @error('avatar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


        </div>

        <!-- Dirección -->
        <div>
            <label for="address" class="form-label">Adress</label>
            <input id="address" name="address" type="text"
                value="{{ old('address', auth()->user()->profile?->address) }}" class="form-input">

            @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </div>
    </form>
@endsection
