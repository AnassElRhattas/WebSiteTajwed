<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tajwed') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Tajwed</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="space-x-4">
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-semibold">Dashboard</a>
                                @else
                                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-semibold">Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-semibold">Se connecter</a>
                                <a href="{{ route('register') }}" class="ml-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-semibold">S'inscrire</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Welcome to Tajwed Learning Platform</h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">Learn Tajwed with interactive lessons and quizzes</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>