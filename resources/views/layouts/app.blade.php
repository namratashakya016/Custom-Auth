<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    @vite(['resources/css/app.css','resources/css/nav.css'])
</head>
<body class="bg-gray-100 text-gray-900">
    @include('components.navigation')
    <main class="p-6">
    @yield('content')
    </main>
</body>
</html>
