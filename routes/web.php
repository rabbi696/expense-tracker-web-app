<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/calculator', function () {
    return view('calculator');
})->name('calculator');

Route::get('/notes', function () {
    return view('notes');
})->name('notes');

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::resource('expenses', App\Http\Controllers\ExpenseController::class);
Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::get('reports/monthly/{year?}/{month?}', [App\Http\Controllers\ReportController::class, 'monthlyReport'])->name('reports.monthly');
Route::get('reports/monthly/export/{format?}', [App\Http\Controllers\ReportController::class, 'exportMonthlyReport'])->name('reports.monthly.export');
Route::get('reports/user/{user}', [App\Http\Controllers\ReportController::class, 'userReport'])->name('reports.user');
Route::get('reports/user/{user}/export/{format?}', [App\Http\Controllers\ReportController::class, 'exportUserReport'])->name('reports.user.export');
Route::get('reports/trends', [App\Http\Controllers\ReportController::class, 'trendsReport'])->name('reports.trends');
Route::get('reports/cashflow', [App\Http\Controllers\ReportController::class, 'cashFlowReport'])->name('reports.cashflow');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('debts', App\Http\Controllers\DebtController::class);
    Route::resource('bills', App\Http\Controllers\BillController::class);
    Route::resource('incomes', App\Http\Controllers\IncomeController::class);
    

    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('password.change');
    Route::post('/password/change', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});