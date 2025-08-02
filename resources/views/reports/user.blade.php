@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Expense Report for ' . $user->name) }}</span>
                    <div class="dropdown ms-2">
                        <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Export
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li><a class="dropdown-item" href="{{ route('reports.user.export', ['user' => $user->id, 'format' => 'xlsx']) }}">Excel (XLSX)</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.user.export', ['user' => $user->id, 'format' => 'csv']) }}">CSV</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.user.export', ['user' => $user->id, 'format' => 'pdf']) }}">PDF</a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Month/Year Filter Form -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" action="{{ route('reports.user', $user->id) }}" class="d-flex align-items-end gap-3">
                                <div class="form-group">
                                    <label for="month" class="form-label">Month</label>
                                    <select name="month" id="month" class="form-select">
                                        <option value="">All Months</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $currentMonth == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="year" class="form-label">Year</label>
                                    <select name="year" id="year" class="form-select">
                                        @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                                            <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Current Selection Display -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                Showing report for: <strong>
                                    @if($currentMonth)
                                        {{ DateTime::createFromFormat('!m', $currentMonth)->format('F') }} {{ $currentYear }}
                                    @else
                                        All months of {{ $currentYear }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="fas fa-users"></i> Total Expense (All Users)</h6>
                                    <h3 class="mb-0">৳{{ number_format($allExpenses, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card bg-info bg-opacity-10">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="fas fa-chart-pie"></i> Your Share of Expenses</h6>
                                    <h3 class="mb-0 text-info">৳{{ number_format($totalExpenses, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card bg-success bg-opacity-10">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="fas fa-wallet"></i> Total Money Added for You</h6>
                                    <h3 class="mb-0 text-success">৳{{ number_format($totalIncome, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        @if ($otherUsersAddedMoney > 0)
                        <div class="col-md-6 mb-4">
                            <div class="card bg-warning bg-opacity-10">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2"><i class="fas fa-hand-holding-usd"></i> Money Added by Others</h6>
                                    <h3 class="mb-0 text-warning">৳{{ number_format($otherUsersAddedMoney, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            @if ($remainingCash < 0)
                            <div class="card bg-danger bg-opacity-10 border-danger">
                                <div class="card-body text-center py-4">
                                    <h5 class="text-muted mb-2"><i class="fas fa-exclamation-circle"></i> Total Due</h5>
                                    <h2 class="mb-0 text-danger">৳{{ number_format(abs($remainingCash), 2) }}</h2>
                                </div>
                            </div>
                            @else
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body text-center py-4">
                                    <h5 class="text-muted mb-2"><i class="fas fa-check-circle"></i> Remaining Cash</h5>
                                    <h2 class="mb-0 text-success">৳{{ number_format($remainingCash, 2) }}</h2>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
