@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Monthly Expense Report') }}</div>

                <div class="card-body">
                    <form action="{{ route('reports.monthly') }}" method="GET" class="mb-4">
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
                                <div class="dropdown ms-2">
                                    <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Export
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                        <li><a class="dropdown-item" href="{{ route('reports.monthly.export', ['year' => $year, 'month' => $month, 'format' => 'xlsx']) }}">Excel (XLSX)</a></li>
                                        <li><a class="dropdown-item" href="{{ route('reports.monthly.export', ['year' => $year, 'month' => $month, 'format' => 'csv']) }}">CSV</a></li>
                                        <li><a class="dropdown-item" href="{{ route('reports.monthly.export', ['year' => $year, 'month' => $month, 'format' => 'pdf']) }}">PDF</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if (empty($monthlyReports))
                        <p>No expenses recorded for the selected period.</p>
                    @else
                        @foreach ($monthlyReports as $month => $report)
                            <div class="mb-4">
                                <h3>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</h3>
                                <p><strong>Total Monthly Expense:</strong> ৳{{ number_format($report['total'], 2) }}</p>

                                @if ($report['categories']->isEmpty())
                                    <p>No category breakdown for this month.</p>
                                @else
                                    <h5>Category Breakdown:</h5>
                                    <ul>
                                        @foreach ($report['categories'] as $categoryName => $categoryTotal)
                                            <li>{{ $categoryName }}: ${{ number_format($categoryTotal, 2) }}</li>
                                        @endforeach
                                    </ul>

                                    <div class="mt-4 d-flex justify-content-center" style="max-height: 400px;">
                                        <canvas id="categoryPieChart-{{ $month }}" class="mx-auto"></canvas>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const ctx = document.getElementById('categoryPieChart-{{ $month }}').getContext('2d');
                                            new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: {!! json_encode($report['categories']->keys()) !!},
                                                    datasets: [{
                                                        data: {!! json_encode($report['categories']->values()) !!},
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
                                                            text: 'Category Breakdown for {{ \Carbon\Carbon::parse($month)->format('F Y') }}'
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                @endif
                            </div>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
