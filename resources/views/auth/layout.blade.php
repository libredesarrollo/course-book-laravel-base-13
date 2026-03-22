<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>

<body>

    @if (session('status'))
        {{ session('status') }}
    @endif

    <div class="container max-w-96 mt-5">
        <div class="card">
            @yield('content')
        </div>
    </div>
</body>

</html>