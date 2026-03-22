<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auth</title>
    @vite(['resources/css/dashboard.css'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-4">
        <div class="card">


            @if (session('status'))
                <div class="status-box max-w-xl ml-2 my-3">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>

</html>
