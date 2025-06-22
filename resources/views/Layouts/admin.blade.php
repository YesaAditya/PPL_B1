<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'RDFarm' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#253a7d',
                        secondary: '#071952',
                        accent: '#37B7C3',
                        lightbg: '#eaf4f8',
                    },
                    transitionProperty: {
                        'shadow-border': 'box-shadow, border-color',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eaf4f8;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('Components.NavbarAdmin')

    {{-- Main Content --}}
    <main class="pt-[140px] px-[190px] pb-[120px]">
        @yield('content')
    </main>

</body>
</html>
