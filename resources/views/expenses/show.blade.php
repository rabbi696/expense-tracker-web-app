@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Expense Details') }}</span>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-sm">Back to Expenses</a>
                </div>

                <div class="card-body">
                    <p><strong>Amount:</strong> ৳{{ number_format($expense->amount, 2) }}</p>
                    <p><strong>Category:</strong> {{ $expense->category ? $expense->category->name : 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $expense->description }}</p>
                    <p><strong>Purchase From:</strong> {{ $expense->purchase_from ?? 'N/A' }}</p>
                    <p><strong>Assigned To:</strong> {{ $expense->assignedToUser ? $expense->assignedToUser->name : 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ $expense->expense_date->format('M d, Y') }}</p>

                    @if ($expense->receipt_path)
                        <div class="mb-3">
                            <strong>Receipt:</strong><br>
                            <img src="{{ asset('storage/' . $expense->receipt_path) }}" alt="Receipt" class="img-fluid" style="max-width: 300px;">
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit Expense</a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this expense?')">Delete Expense</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
