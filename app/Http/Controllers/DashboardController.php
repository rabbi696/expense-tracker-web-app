<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $loggedInUser = Auth::user();

        $expensesQuery = Expense::query();
        $incomeQuery = Income::query();

        // Total Expenses for current month
        $totalExpenses = $expensesQuery
            ->whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->sum('amount');

        // Total Income for current month
        $totalIncome = $incomeQuery
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount');

        // Category Breakdown for current month
        $categoryBreakdown = Expense::with('category')
            ->whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->get()
            ->groupBy(function ($expense) {
                return $expense->category->name ?? 'Uncategorized';
            })
            ->map(function ($expenses) {
                return $expenses->sum('amount');
            });

        // Recent Transactions (Expenses and Income)
        $recentExpenses = Expense::with(['category', 'assignedToUser'])->latest('expense_date')->paginate(5, ['*'], 'expenses_page') ?? collect();
        $recentIncomes = $incomeQuery->with('assignedToUser')->latest('date')->paginate(5, ['*'], 'incomes_page') ?? collect();

        return view('dashboard', compact('totalExpenses', 'totalIncome', 'categoryBreakdown', 'recentExpenses', 'recentIncomes'));
    }
}
