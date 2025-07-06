<?php

namespace App\Exports;

use App\Models\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $year;

    protected $month;

    protected $userId;

    public function __construct($year = null, $month = null)
    {
        $this->year = $year ?? Carbon::now()->year;
        $this->month = $month;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $expensesQuery = Expense::query();

        $expensesQuery->whereYear('expense_date', $this->year);

        if ($this->month) {
            $expensesQuery->whereMonth('expense_date', $this->month);
        }

        return $expensesQuery->with(['categories', 'assignedToUser'])->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Amount',
            'Categories',
            'Description',
            'Assigned To',
            'Purchase From',
        ];
    }

    public function map($expense): array
    {
        return [
            Carbon::parse($expense->expense_date)->format('Y-m-d'),
            $expense->amount,
            $expense->categories->pluck('name')->implode(', '),
            $expense->description,
            $expense->assignedToUser ? $expense->assignedToUser->name : 'N/A',
            $expense->purchase_from ?? 'N/A',
        ];
    }
}
