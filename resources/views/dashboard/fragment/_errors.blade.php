{{-- @if ($errors->any()) --}}
    @foreach ($errors->all() as $e)
        <div class="error-form">
            {{ $e }}
        </div>
    @endforeach
{{-- @endif --}}