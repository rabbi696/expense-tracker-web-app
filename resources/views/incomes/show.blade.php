@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Income Details') }}</span>
                    <a href="{{ route('incomes.index') }}" class="btn btn-secondary btn-sm">Back to Income</a>
                </div>

                <div class="card-body">
                    <p><strong>Amount:</strong> ৳{{ number_format($income->amount, 2) }}</p>
                    <p><strong>Notes:</strong> {{ $income->notes ?? 'N/A' }}</p>
                    <p><strong>Assigned To:</strong> {{ $income->assignedToUser ? $income->assignedToUser->name : 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($income->date)->format('M d, Y') }}</p>

                    <div class="mt-4">
                        <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning">Edit Income</a>
                        <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this income?')">Delete Income</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
