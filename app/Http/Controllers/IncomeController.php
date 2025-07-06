<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
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
        $incomesQuery = Income::with('assignedToUser');

        

        $incomes = $incomesQuery->latest()->get();

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        return view('incomes.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:255',
            'date' => 'required|date',
            'assigned_to_user_id' => 'required|exists:users,id',
        ]);

        Auth::user()->incomes()->create([
            'amount' => $request->amount,
            'notes' => $request->notes,
            'date' => $request->date,
            'assigned_to_user_id' => $request->assigned_to_user_id,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        // Ensure user owns the income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        return view('incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        // Ensure user owns the income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        $users = User::all();

        return view('incomes.edit', compact('income', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        // Ensure user owns the income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:255',
            'date' => 'required|date',
            'assigned_to_user_id' => 'required|exists:users,id',
        ]);

        $income->update([
            'amount' => $request->amount,
            'notes' => $request->notes,
            'date' => $request->date,
            'assigned_to_user_id' => $request->assigned_to_user_id,
        ]);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        // Ensure user owns the income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully!');
    }
}
