<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        
        @stack('css')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- Material Symbols --}}
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    </head>
    <body>
        <main class="bg-[#F6F7F9]">@yield('content')</main>
        @stack('js')
    </body>
</html>
