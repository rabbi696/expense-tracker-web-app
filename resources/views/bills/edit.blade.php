@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Bill') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bills.update', $bill->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Bill Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $bill->name) }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $bill->amount) }}" step="0.01" required>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $bill->due_date->format('Y-m-d')) }}" required>
                            @error('due_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="frequency" class="form-label">Frequency</label>
                            <select class="form-select @error('frequency') is-invalid @enderror" id="frequency" name="frequency" required>
                                <option value="daily" {{ old('frequency', $bill->frequency) == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ old('frequency', $bill->frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ old('frequency', $bill->frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ old('frequency', $bill->frequency) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="yearly" {{ old('frequency', $bill->frequency) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            @error('frequency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_to_user_id" class="form-label">Assigned To User</label>
                            <select class="form-select @error('assigned_to_user_id') is-invalid @enderror" id="assigned_to_user_id" name="assigned_to_user_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to_user_id', $bill->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('assigned_to_user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_paid" name="is_paid" value="1" {{ old('is_paid', $bill->is_paid) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_paid">Mark as Paid</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Bill</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
