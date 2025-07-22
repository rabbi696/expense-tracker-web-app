@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Expenses') }}</span>
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">Add New Expense</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('expenses.index') }}" method="GET" class="mb-4">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="keyword" class="form-label">Keyword</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" value="{{ request('keyword') }}" placeholder="Search description">
                            </div>
                            <div class="col-md-4">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="assigned_to_user_id" class="form-label">Assigned To</label>
                                <select class="form-select" id="assigned_to_user_id" name="assigned_to_user_id">
                                    <option value="">All Users</option>
                                    @foreach ($users as $userOption)
                                        <option value="{{ $userOption->id }}" {{ request('assigned_to_user_id') == $userOption->id ? 'selected' : '' }}>{{ $userOption->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="purchase_from" class="form-label">Purchase From</label>
                                <select class="form-select" id="purchase_from" name="purchase_from">
                                    <option value="">All Locations</option>
                                    <option value="Supershop" {{ request('purchase_from') == 'Supershop' ? 'selected' : '' }}>Supershop</option>
                                    <option value="eCommerce" {{ request('purchase_from') == 'eCommerce' ? 'selected' : '' }}>eCommerce</option>
                                    <option value="Bazar" {{ request('purchase_from') == 'Bazar' ? 'selected' : '' }}>Bazar</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="min_amount" class="form-label">Min Amount</label>
                                <input type="number" class="form-control" id="min_amount" name="min_amount" value="{{ request('min_amount') }}" step="0.01">
                            </div>
                            <div class="col-md-3">
                                <label for="max_amount" class="form-label">Max Amount</label>
                                <input type="number" class="form-control" id="max_amount" name="max_amount" value="{{ request('max_amount') }}" step="0.01">
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Clear Filters</a>
                            </div>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($expenses->isEmpty())
                        <p>No expenses recorded yet. Start by adding a new one!</p>
                    @else
                        <div class="alert alert-info mb-3">
                            <strong>Filtered Total:</strong> ৳{{ number_format($filteredTotal, 2) }}
                            <small class="text-muted">({{ $expenses->total() }} expenses found)</small>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Assigned To</th>
                                    <th>Purchase From</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                        <td>৳{{ number_format($expense->amount, 2) }}</td>
                                        <td>{{ $expense->category ? $expense->category->name : 'N/A' }}</td>
                                        <td>{{ $expense->description }}</td>
                                        <td>{{ $expense->assignedToUser ? $expense->assignedToUser->name : 'N/A' }}</td>
                                        <td>{{ $expense->purchase_from ?? 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-info btn-sm me-1">View</a>
                                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $expenses->withQueryString()->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
