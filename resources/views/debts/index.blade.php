@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Debt Management') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($debts->isEmpty())
                        <p>No debts to display.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Payer</th>
                                    <th>Debtor</th>
                                    <th>Expense Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($debts as $debt)
                                    <tr>
                                        <td>{{ $debt->payer->name }}</td>
                                        <td>{{ $debt->debtor->name }}</td>
                                        <td>{{ $debt->expense->description ?? 'N/A' }}</td>
                                        <td>${{ number_format($debt->amount, 2) }}</td>
                                        <td>
                                            @if ($debt->is_settled)
                                                <span class="badge bg-success">Settled</span>
                                            @else
                                                <span class="badge bg-danger">Outstanding</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$debt->is_settled && (Auth::user()->id == $debt->payer_id || Auth::user()->id == $debt->debtor_id))
                                                <form action="{{ route('debts.update', $debt->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_settled" value="1">
                                                    <button type="submit" class="btn btn-success btn-sm">Mark as Settled</button>
                                                </form>
                                            @endif
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
