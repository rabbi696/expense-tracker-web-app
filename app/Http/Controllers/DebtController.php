<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
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
        $debtsQuery = Debt::with(['payer', 'debtor', 'expense']);

        if ($user->role !== 'admin') {
            $debtsQuery->where(function ($query) use ($user) {
                $query->where('payer_id', $user->id)
                    ->orWhere('debtor_id', $user->id);
            });
        }

        $debts = $debtsQuery->get();

        return view('debts.index', compact('debts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for this feature
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Not needed for this feature
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not needed for this feature
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not needed for this feature
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debt $debt)
    {
        // Only the payer or debtor can mark a debt as settled
        if (Auth::user()->id !== $debt->payer_id && Auth::user()->id !== $debt->debtor_id) {
            abort(403, 'Unauthorized action.');
        }

        $debt->update(['is_settled' => $request->has('is_settled')]);

        return redirect()->route('debts.index')->with('success', 'Debt updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Not needed for this feature
    }
}
