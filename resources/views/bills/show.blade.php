@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Bill Details') }}</span>
                    <a href="{{ route('bills.index') }}" class="btn btn-secondary btn-sm">Back to Bills</a>
                </div>

                <div class="card-body">
                    <p><strong>Name:</strong> {{ $bill->name }}</p>
                    <p><strong>Amount:</strong> ${{ number_format($bill->amount, 2) }}</p>
                    <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</p>
                    <p><strong>Frequency:</strong> {{ ucfirst($bill->frequency) }}</p>
                    <p><strong>Status:</strong>
                        @if ($bill->is_paid)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('bills.edit', $bill->id) }}" class="btn btn-warning">Edit Bill</a>
                        <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this bill?')">Delete Bill</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
