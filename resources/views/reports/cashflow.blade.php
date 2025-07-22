@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Cash Flow Report') }}</div>

                <div class="card-body">
                    <form action="{{ route('reports.cashflow') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="month" class="form-label">Month</label>
                                <select name="month" id="month" class="form-select">
                                    <option value="">All Months</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ (isset($month) && $month == $i) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" name="year" id="year" class="form-control" value="{{ $year ?? \Carbon\Carbon::now()->year }}" min="2000" max="2100">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter Report</button>
                            </div>
                        </div>
                    </form>

                    <div class="mb-3">
                        <p><strong>Total Income:</strong> ৳{{ number_format($totalIncome, 2) }}</p>
                        <p><strong>Total Expenses:</strong> ৳{{ number_format($totalExpenses, 2) }}</p>
                        <p><strong>Net Cash Flow:</strong> ৳{{ number_format($netCashFlow, 2) }}</p>
                        @if ($totalIncome > $totalExpenses)
                            <p class="text-success"><strong>Remaining Cash:</strong> ৳{{ number_format($totalIncome - $totalExpenses, 2) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
