<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Tracker - Take Control of Your Finances</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles & Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased">
    <div class="flex flex-col min-h-screen">
        <header class="w-full py-4 px-6 lg:px-8">
            <div class="container mx-auto flex items-center justify-between">
                <a href="/" class="text-xl font-bold text-gray-900 dark:text-white">
                    ExpenseTracker
                </a>
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-grow">
            <section class="text-center py-20 lg:py-32">
                <div class="container mx-auto px-6">
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                        Take Control of Your Finances
                    </h1>
                    <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-8">
                        The simple, intuitive way to track your monthly expenses, manage bills, and achieve your financial goals.
                    </p>
                    <a href="{{ route('register') }}" class="px-8 py-4 text-lg font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                        Get Started for Free
                    </a>
                </div>
            </section>

            <!-- Features Section -->
            <section class="bg-white dark:bg-gray-800 py-20">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">Everything You Need to Succeed</h2>
                        <p class="text-md text-gray-600 dark:text-gray-400 mt-2">A few key features to get you started.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Log Expenses</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Quickly and easily add your daily expenses on the go from any device.
                            </p>
                        </div>
                        <!-- Feature 2 -->
                        <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto mb-4">
                               <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h5zM7 13h5a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2h5z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Categorize Spending</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Organize your expenses into custom categories to see exactly where your money is going.
                            </p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto mb-4">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Visualize Reports</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Understand your spending habits with simple, clear monthly reports and cash flow analysis.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-200 dark:bg-gray-800 py-6">
            <div class="container mx-auto text-center text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} ExpenseTracker. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
