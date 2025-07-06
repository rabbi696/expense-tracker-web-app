<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyReportExport;
use App\Exports\UserReportExport;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Debt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function monthlyReport(Request $request)
    {
        $loggedInUser = Auth::user();

        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $expensesQuery = Expense::with('category');

        $expensesQuery->whereYear('expense_date', $year);

        if ($month) {
            $expensesQuery->whereMonth('expense_date', $month);
        }

        $expenses = $expensesQuery->orderBy('expense_date', 'asc')
            ->get();

        $monthlyReports = [];
        foreach ($expenses as $expense) {
            $monthKey = Carbon::parse($expense->expense_date)->format('Y-m');
            if (! isset($monthlyReports[$monthKey])) {
                $monthlyReports[$monthKey] = [
                    'total' => 0,
                    'categories' => collect(),
                ];
            }
            $monthlyReports[$monthKey]['total'] += $expense->amount;
            if ($expense->category) {
                $monthlyReports[$monthKey]['categories']->put(
                    $expense->category->name,
                    ($monthlyReports[$monthKey]['categories']->get($expense->category->name) ?? 0) + $expense->amount
                );
            }
        }

        return view('reports.monthly', compact('monthlyReports', 'year', 'month'));
    }

    public function exportMonthlyReport(Request $request, $format = 'xlsx')
    {
        $loggedInUser = Auth::user();
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);
        $fileName = 'monthly_expense_report.'.$format;

        return Excel::download(new MonthlyReportExport($year, $month), $fileName, \Maatwebsite\Excel\Excel::class.'::'.strtoupper($format));
    }

    public function userReport(User $user)
    {
        $loggedInUser = Auth::user();
        // Ensure only admin or the user themselves can view this report
        if ($loggedInUser->id !== $user->id && $loggedInUser->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Get all non-admin users count
        $userCount = User::where('role', '!=', 'admin')->count();

        // Get total expenses for the current month for all non-admin users
        $totalMonthlyExpenses = Expense::whereHas('user', function ($query) {
            $query->where('role', '!=', 'admin');
        })
            ->whereYear('expense_date', $currentYear)
            ->whereMonth('expense_date', $currentMonth)
            ->sum('amount');

        // Calculate per user expense
        $totalExpenses = $userCount > 0 ? $totalMonthlyExpenses / $userCount : 0;

        $expenses = $user->expenses()->with('category')
            ->whereYear('expense_date', $currentYear)
            ->whereMonth('expense_date', $currentMonth)
            ->get();

        $totalIncome = $user->incomes()
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');

        $remainingCash = $user->monthly_allocation + $totalIncome - $totalExpenses;
        $dueAmount = ($remainingCash < 0) ? abs($remainingCash) : 0;

        $totalOwedBy = Debt::where('debtor_id', $user->id)->where('is_settled', false)->sum('amount');
        $totalOwedTo = Debt::where('payer_id', $user->id)->where('is_settled', false)->sum('amount');
        $netDue = $totalOwedBy - $totalOwedTo;

        $debtsOwedToUser = Debt::with('debtor', 'expense')->where('payer_id', $user->id)->where('is_settled', false)->get();
        $debtsOwedByUser = Debt::with('payer', 'expense')->where('debtor_id', $user->id)->where('is_settled', false)->get();

        // For category breakdown in user report
        $categoryBreakdown = collect();
        foreach ($expenses as $expense) {
            if ($expense->category) {
                $categoryBreakdown->put(
                    $expense->category->name,
                    ($categoryBreakdown->get($expense->category->name) ?? 0) + $expense->amount
                );
            }
        }

        return view('reports.user', compact('user', 'totalExpenses', 'remainingCash', 'dueAmount', 'expenses', 'categoryBreakdown', 'totalOwedBy', 'totalOwedTo', 'netDue'));
    }

    public function exportUserReport(User $user, $format = 'xlsx')
    {
        $loggedInUser = Auth::user();
        // Ensure only admin or the user themselves can view this report
        if ($loggedInUser->id !== $user->id && $loggedInUser->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $fileName = 'user_expense_report_'.$user->id.'.'.$format;

        return Excel::download(new UserReportExport($user), $fileName, \Maatwebsite\Excel\Excel::class.'::'.strtoupper($format));
    }

    public function trendsReport()
    {
        $loggedInUser = Auth::user();
        $expensesQuery = Expense::query();

        $expenses = $expensesQuery
            ->selectRaw("SUM(amount) as total_amount, DATE_FORMAT(expense_date, '%Y-%m') as month")
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $months = $expenses->pluck('month');
        $amounts = $expenses->pluck('total_amount');

        return view('reports.trends', compact('months', 'amounts'));
    }

    public function cashFlowReport(Request $request)
    {
        $loggedInUser = Auth::user();

        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $incomeQuery = Income::query();
        $totalIncome = $incomeQuery
            ->whereYear('date', $year)
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('date', $month);
            })
            ->sum('amount');

        $expensesQuery = Expense::query();
        $totalExpenses = $expensesQuery
            ->whereYear('expense_date', $year)
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('expense_date', $month);
            })
            ->sum('amount');

        $netCashFlow = $totalIncome - $totalExpenses;

        return view('reports.cashflow', compact('totalIncome', 'totalExpenses', 'netCashFlow', 'year', 'month'));
    }
}
