<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Ideas</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background text-foreground">
        <x-layout.nav />
        <main class="max-w-7xl mx-auto px-6">
            {{ $slot }}
        </main>

        <div x-data="{ greeting: 'Hello' }">
            <p x-text="greeting"></p>
            <input type='text' x-model='greeting'>
        </div>
        
        @session('success')
            <div class="bg-primary px-4py-3 absolute bottom-4 right-4 rounded-lg">{{ $value }}</div>
        @endsession
    </body>
</html>
