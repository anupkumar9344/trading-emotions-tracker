<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trading Strategy Tracker')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        select, textarea {
            padding: 0.5rem;
            border-radius: 0.25rem;
            border: 1px solid #c2c2c2;
            background-color: #fff;
            color: #1a202c;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            margin-bottom: 1rem;
            width: 100%;
            box-sizing: border-box;
        }
        
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('trades.index') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                        Trading Strategy Tracker
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="relative">
                        <select style="margin: 0;" onchange="window.location.href='/language/' + this.value" 
                            class="text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                            <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>हिंदी</option>
                        </select>
                    </div>
                    
                    <a href="{{ route('trades.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        {{ __('messages.dashboard') }}
                    </a>
                    <a href="{{ route('trades.history') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        {{ __('messages.history') }}
                    </a>
                    @auth
                        @if(Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                    {{ __('messages.logout') }}
                                </button>
                            </form>
                        @endif
                    @else
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                {{ __('messages.login') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>

