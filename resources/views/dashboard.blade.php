@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-header">Total Expenses (Current Month)</div>
                                <div class="card-body">
                                    <h5 class="card-title">৳{{ number_format($totalExpenses, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header">Total Income (Current Month)</div>
                                <div class="card-body">
                                    <h5 class="card-title">৳{{ number_format($totalIncome, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-header">Net Cash Flow (Current Month)</div>
                                <div class="card-body">
                                    <h5 class="card-title">৳{{ number_format($totalIncome - $totalExpenses, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Category Breakdown (Current Month)</div>
                                <div class="card-body">
                                    <canvas id="categoryBreakdownChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Recent Transactions</div>
                                <div class="card-body">
                                    <h5>Recent Expenses:</h5>
                                    @if ($recentExpenses->isEmpty())
                                        <p>No recent expenses.</p>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentExpenses as $expense)
                                                    <tr>
                                                        <td>{{ $expense->category ? $expense->category->name : 'N/A' }}</td>
                                                        <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                                        <td><span class="badge bg-danger rounded-pill">-৳{{ number_format($expense->amount, 2) }}</span></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $recentExpenses->links('pagination::bootstrap-4') }}
                                    @endif

                                    <h5>Recent Income:</h5>
                                    @if ($recentIncomes->isEmpty())
                                        <p>No recent income.</p>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentIncomes as $income)
                                                    <tr>
                                                        <td>{{ $income->assignedToUser ? $income->assignedToUser->name : 'N/A' }}</td>
                                                        <td>{{ $income->created_at->format('M d, Y') }}</td>
                                                        <td><span class="badge bg-success rounded-pill">+৳{{ number_format($income->amount, 2) }}</span></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $recentIncomes->links('pagination::bootstrap-4') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Category Breakdown Chart
        const categoryCtx = document.getElementById('categoryBreakdownChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoryBreakdown->keys()) !!},
                datasets: [{
                    data: {!! json_encode($categoryBreakdown->values()) !!},
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#8D6E63',
                        '#FFD54F',
                        '#66BB6A',
                        '#EF5350',
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Category Breakdown (Current Month)'
                    }
                }
            }
        });
    });
</script>
@endsection
