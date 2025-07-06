@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Invoice Details') }}</span>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary btn-sm">Back to Invoices</a>
                </div>

                <div class="card-body">
                    <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                    <p><strong>Amount:</strong> ৳{{ number_format($invoice->amount, 2) }}</p>
                    <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                    <p><strong>Status:</strong>
                        @if ($invoice->status == 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif ($invoice->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Overdue</span>
                        @endif
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning">Edit Invoice</a>
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?')">Delete Invoice</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
