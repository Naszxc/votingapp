<!DOCTYPE html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- @vite(['resources/js/app.js', 'resources/css/app.sass', 'resources/js/login.js']) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         @vite('resources/css/app.sass')
    </head>

    <body>
        @yield('content')
    </body>
</html>