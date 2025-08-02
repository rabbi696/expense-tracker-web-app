<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $expensesQuery = Expense::with(['category', 'assignedToUser']);

        // Filter by category
        if ($request->filled('category_id')) {
            $expensesQuery->where('category_id', $request->category_id);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to_user_id')) {
            $expensesQuery->where('assigned_to_user_id', $request->assigned_to_user_id);
        }

        // Filter by amount range
        if ($request->filled('min_amount')) {
            $expensesQuery->where('amount', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $expensesQuery->where('amount', '<=', $request->max_amount);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $expensesQuery->whereDate('expense_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $expensesQuery->whereDate('expense_date', '<=', $request->end_date);
        }

        // Search by keyword in description
        if ($request->filled('keyword')) {
            $keyword = '%'.$request->keyword.'%';
            $expensesQuery->where(function ($query) use ($keyword) {
                $query->where('description', 'like', $keyword);
            });
        }

        // Filter by purchase_from
        if ($request->filled('purchase_from')) {
            $expensesQuery->where('purchase_from', $request->purchase_from);
        }

        $expenses = $expensesQuery->latest('expense_date')->paginate(15);
        $categories = Category::all();
        $users = User::all();
        
        // Calculate total based on filters
        $filteredTotal = $expensesQuery->sum('amount');

        return view('expenses.index', compact('expenses', 'categories', 'users', 'request', 'filteredTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all();

        return view('expenses.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'receipt_path' => 'nullable|image|max:2048', // Max 2MB
            'assigned_to_user_id' => 'required|exists:users,id',
            'expense_date' => 'required|date',
            'is_group_expense' => 'boolean',
            'group_members' => 'array',
            'group_members.*' => 'exists:users,id',
            'purchase_from' => 'nullable|in:Supershop,eCommerce,Bazar',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt_path')) {
            $receiptPath = $request->file('receipt_path')->store('receipts', 'public');
        }

        $expense = Auth::user()->expenses()->create([
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $receiptPath,
            'assigned_to_user_id' => $request->assigned_to_user_id,
            'expense_date' => $request->expense_date,
            'is_group_expense' => $request->has('is_group_expense'),
            'purchase_from' => $request->purchase_from,
            'category_id' => $request->category_id,
        ]);

        // Create corresponding income record to balance the cash flow
        // This represents the money that was added to pay for this expense
        Income::create([
            'amount' => $request->amount,
            'description' => 'Money added for expense: ' . ($request->description ?: 'Expense'),
            'date' => $request->expense_date,
            'user_id' => Auth::id(), // Who added the money
            'assigned_to_user_id' => $request->assigned_to_user_id, // Who the money is for
        ]);

        // Group expense logic can be added here if needed in the future

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $this->authorize('view', $expense); // Ensure user can view this expense

        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense); // Ensure user can update this expense
        $categories = Category::all();
        $users = User::all();

        return view('expenses.edit', compact('expense', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense); // Ensure user can update this expense

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'receipt_path' => 'nullable|image|max:2048', // Max 2MB
            'assigned_to_user_id' => 'required|exists:users,id',
            'expense_date' => 'required|date',
            'is_group_expense' => 'boolean',
            'group_members' => 'array',
            'group_members.*' => 'exists:users,id',
            'purchase_from' => 'nullable|in:Supershop,eCommerce,Bazar',
        ]);

        $receiptPath = $expense->receipt_path;
        if ($request->hasFile('receipt_path')) {
            // Delete old receipt if exists
            if ($receiptPath) {
                Storage::disk('public')->delete($receiptPath);
            }
            $receiptPath = $request->file('receipt_path')->store('receipts', 'public');
        }

        $expense->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $receiptPath,
            'assigned_to_user_id' => $request->assigned_to_user_id,
            'expense_date' => $request->expense_date,
            'is_group_expense' => $request->has('is_group_expense'),
            'purchase_from' => $request->purchase_from,
            'category_id' => $request->category_id,
        ]);

        // Group expense logic can be added here if needed in the future

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense); // Ensure user can delete this expense

        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }
}
