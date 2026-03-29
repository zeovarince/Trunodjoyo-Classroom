<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Trunojoyo Classroom') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-black">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black">
            <div class="mb-4">
                <a href="/">
                    <h1 class="text-4xl font-bold text-yellow-500">Trunojoyo <span class="text-white">Classroom</span></h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-zinc-900 shadow-xl overflow-hidden sm:rounded-xl border-2 border-yellow-600">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-gray-500">
                &copy; {{ date('Y') }} Teknik Informatika - Universitas Trunojoyo Madura
            </p>
        </div>
    </body>
</html>