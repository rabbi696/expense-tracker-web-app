@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Expense') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" required>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="purchase_from" class="form-label">Purchase From</label>
                            <select class="form-select @error('purchase_from') is-invalid @enderror" id="purchase_from" name="purchase_from">
                                <option value="">Select where purchased from</option>
                                <option value="Supershop" {{ old('purchase_from') == 'Supershop' ? 'selected' : '' }}>Supershop</option>
                                <option value="eCommerce" {{ old('purchase_from') == 'eCommerce' ? 'selected' : '' }}>eCommerce</option>
                                <option value="Bazar" {{ old('purchase_from') == 'Bazar' ? 'selected' : '' }}>Bazar</option>
                            </select>
                            @error('purchase_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_to_user_id" class="form-label">Assign to User</label>
                            <select class="form-select @error('assigned_to_user_id') is-invalid @enderror" id="assigned_to_user_id" name="assigned_to_user_id" required>
                                <option value="">Select a user</option>
                                @foreach ($users as $userOption)
                                    <option value="{{ $userOption->id }}" {{ old('assigned_to_user_id') == $userOption->id ? 'selected' : '' }}>{{ $userOption->name }}</option>
                                @endforeach
                            </select>
                            @error('assigned_to_user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Expense Date</label>
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror" id="expense_date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                            @error('expense_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        

                        <div class="mb-3">
                            <label for="receipt_path" class="form-label">Receipt (Optional)</label>
                            <input type="file" class="form-control @error('receipt_path') is-invalid @enderror" id="receipt_path" name="receipt_path">
                            @error('receipt_path')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        

                        <button type="submit" class="btn btn-primary">Add Expense</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection