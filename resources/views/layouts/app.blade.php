<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="app">
        <div class="sidebar">
            <h3 class="text-center p-3">SolveEz</h3>
            <ul class="nav flex-column">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt icon"></i><span class="text">Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expenses.index') }}"><i class="fas fa-money-bill-wave icon"></i><span class="text">Expenses</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}"><i class="fas fa-tags icon"></i><span class="text">Categories</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.monthly') }}"><i class="fas fa-chart-pie icon"></i><span class="text">Monthly Report</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.user', Auth::user()->id) }}"><i class="fas fa-user-chart icon"></i><span class="text">My Report</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.trends') }}"><i class="fas fa-chart-line icon"></i><span class="text">Expense Trends</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.cashflow') }}"><i class="fas fa-wallet icon"></i><span class="text">Cash Flow</span></a>
                    </li>
                    
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users-cog icon"></i><span class="text">Manage Users</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.create') }}"><i class="fas fa-user-plus icon"></i><span class="text">Add User</span></a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('debts.index') }}"><i class="fas fa-credit-card icon"></i><span class="text">Debts</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bills.index') }}"><i class="fas fa-file-invoice-dollar icon"></i><span class="text">Bills</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('incomes.index') }}"><i class="fas fa-hand-holding-usd icon"></i><span class="text">Add Money</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('invoices.index') }}"><i class="fas fa-file-invoice icon"></i><span class="text">Invoices</span></a>
                    </li>
                    
                @endauth
            </ul>
        </div>

        <div class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebar-toggle"><i class="fas fa-bars"></i></button>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#calculatorModal">
                                    <i class="fas fa-calculator"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('password.change') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
            <footer class="footer mt-auto py-3 bg-light">
                <div class="container text-center">
                    <span class="text-muted">Developed by <a href="https://golamrabbi.dev" target="_blank">Golam Rabbi</a></span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Calculator Modal -->
    <div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calculatorModalLabel">Calculator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('calculator')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.content').classList.toggle('collapsed');
        });
    </script>
</body>
</html>