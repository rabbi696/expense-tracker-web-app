@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Income') }}</span>
                    <a href="{{ route('incomes.create') }}" class="btn btn-primary btn-sm">Add Money</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($incomes->isEmpty())
                        <p>No income recorded yet. Start by adding a new one!</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                    <th>Assigned To</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incomes as $income)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($income->date)->format('M d, Y') }}</td>
                                        <td>৳{{ number_format($income->amount, 2) }}</td>
                                        <td>{{ $income->notes ?? 'N/A' }}</td>
                                        <td>{{ $income->assignedToUser ? $income->assignedToUser->name : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('incomes.show', $income->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this income?')">Delete</button>
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
