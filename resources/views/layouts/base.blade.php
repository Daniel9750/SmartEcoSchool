<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>

    <!-- CSS -->
    @yield('css')
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;700&display=swap" />
</head>

<body>
    <!-- Navigation -->
    @include('partials.header')

    <!-- Content -->
    @yield('content')

    <!-- JS -->
    @yield('scripts')
</body>

</html>
