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
                    <p><strong>Monthly Allocation:</strong> ৳{{ number_format($user->monthly_allocation, 2) }}</p>
                    <p><strong>Total Expenses (Current Month):</strong> ৳{{ number_format($totalExpenses, 2) }}</p>
                    <p><strong>Remaining Cash:</strong> ৳{{ number_format($remainingCash, 2) }}</p>
                    <p><strong>Total Owed By Others:</strong> ৳{{ number_format($totalOwedTo, 2) }}</p>
                    <p><strong>Total Owed To Others:</strong> ৳{{ number_format($totalOwedBy, 2) }}</p>
                    @if ($netDue > 0)
                        <p class="text-danger"><strong>Net Due (You Owe):</strong> ৳{{ number_format($netDue, 2) }}</p>
                    @elseif ($netDue < 0)
                        <p class="text-success"><strong>Net Due (Owed To You):</strong> ৳{{ number_format(abs($netDue), 2) }}</p>
                    @else
                        <p><strong>Net Due:</strong> ৳0.00</p>
                    @endif

                    <h4 class="mt-4">Expenses for Current Month:</h4>
                    @if ($expenses->isEmpty())
                        <p>No expenses recorded for this user in the current month.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                        <td>৳{{ number_format($expense->amount, 2) }}</td>
                                        <td>
                                            {{ $expense->category ? $expense->category->name : 'N/A' }}
                                        </td>
                                        <td>{{ $expense->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4 class="mt-4">Monthly Expense Breakdown:</h4>
                        <canvas id="userMonthlyExpenseChart"></canvas>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const ctx = document.getElementById('userMonthlyExpenseChart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: {!! json_encode($categoryBreakdown->keys()) !!},
                                        datasets: [{
                                            label: 'Amount',
                                            data: {!! json_encode($categoryBreakdown->values()) !!},
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
