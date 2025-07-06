@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Bills') }}</span>
                    <a href="{{ route('bills.create') }}" class="btn btn-primary btn-sm">Add New Bill</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($bills->isEmpty())
                        <p>No bills recorded yet. Start by adding a new one!</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Frequency</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->name }}</td>
                                        <td>${{ number_format($bill->amount, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</td>
                                        <td>{{ ucfirst($bill->frequency) }}</td>
                                        <td>
                                            @if ($bill->is_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('bills.edit', $bill->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this bill?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
