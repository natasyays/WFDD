<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline System</title>
    <!-- link tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <x-header></x-header>

    <main>
        @yield('content')
    </main>

    <x-footer></x-footer>
</body>

</html>