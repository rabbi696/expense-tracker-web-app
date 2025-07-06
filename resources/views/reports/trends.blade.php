@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Expense Trends Report') }}</div>

                <div class="card-body">
                    @if ($months->isEmpty())
                        <p>No expense data available to show trends.</p>
                    @else
                        <h4>Monthly Expense Totals:</h4>
                        <ul>
                            @foreach ($months as $key => $month)
                                <li>{{ \Carbon\Carbon::parse($month)->format('F Y') }}: ৳{{ number_format($amounts[$key], 2) }}</li>
                            @endforeach
                        </ul>

                        <div class="mt-4">
                            <h5>Expense Trends Chart</h5>
                            <canvas id="expenseTrendsChart"></canvas>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const ctx = document.getElementById('expenseTrendsChart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: {!! json_encode($months->map(fn($m) => \Carbon\Carbon::parse($m)->format('M Y'))) !!},
                                        datasets: [{
                                            label: 'Total Expenses',
                                            data: {!! json_encode($amounts) !!},
                                            borderColor: 'rgb(75, 192, 192)',
                                            tension: 0.1
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
