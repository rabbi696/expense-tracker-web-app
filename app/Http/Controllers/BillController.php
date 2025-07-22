<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $billsQuery = Bill::query();

        $bills = $billsQuery->latest()->get();

        return view('bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
        ]);

        Auth::user()->bills()->create($request->all());

        return redirect()->route('bills.index')->with('success', 'Bill added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        return view('bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        $users = User::all();
        return view('bills.edit', compact('bill', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'is_paid' => 'boolean',
            'assigned_to_user_id' => 'required|exists:users,id',
        ]);

        $bill->update($request->merge(['is_paid' => $request->has('is_paid'), 'user_id' => $request->assigned_to_user_id])->all());

        Log::info('Bill update: is_paid from ' . $bill->getOriginal('is_paid') . ' to ' . $bill->is_paid);

        if ($request->has('is_paid') && $request->is_paid) {
            // Create an expense for the bill amount
            // Note: This will create a new expense every time the bill is marked as paid.
            // If you unmark and then re-mark a bill, a duplicate expense will be created.
            $bill->user->expenses()->create([
                'amount' => $bill->amount,
                'description' => 'Bill payment: ' . $bill->name,
                'expense_date' => now(),
                'user_id' => Auth::id(), // Set the user_id of the expense to the currently authenticated user
                'assigned_to_user_id' => $request->assigned_to_user_id, // Use the selected user ID
                'is_group_expense' => false, // Assuming bill payment is a personal expense
                'category_id' => Category::firstOrCreate(['name' => 'Bills'])->id,
                'bill_id' => $bill->id, // Associate the expense with the bill
            ]);
        } else if (!$request->has('is_paid') || !$request->is_paid) {
            // If the bill is unmarked as paid, delete the associated expense
            $deletedCount = Expense::where('bill_id', $bill->id)->delete();

            // Fallback for older expenses that might not have a bill_id
            if ($deletedCount === 0) {
                Expense::where('amount', $bill->amount)
                       ->where('description', 'LIKE', 'Bill payment: %' . $bill->name . '%')
                       ->delete();
            }
        }

        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        // Delete associated expense if it exists
        Expense::where('bill_id', $bill->id)->delete();

        $bill->delete();

        return redirect()->route('bills.index')->with('success', 'Bill deleted successfully!');
    }
}
