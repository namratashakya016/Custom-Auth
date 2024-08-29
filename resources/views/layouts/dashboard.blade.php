<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="">
    <div id="app">

        <example-component></example-component>

        <a href="{{ route('logout') }}" onclick="event.preventDefault();  handleLogout(); ">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
<script>
    function handleLogout() {
        // Clear localStorage
        localStorage.removeItem('token');
        console.log('Token removed from localStorage');

        // Submit the logout form
        document.getElementById('logout-form').submit();
    }
    @if (isset($token))
        const token = @json($token);
        localStorage.setItem('token', token);
        console.log('Token stored in localStorage:', token);
    @endif
</script>

</html>