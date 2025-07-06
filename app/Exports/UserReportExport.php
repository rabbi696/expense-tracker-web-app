<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $expensesQuery = $this->user->expenses();
        if ($this->user->role !== 'admin') {
            $expensesQuery->where('user_id', $this->user->id);
        }

        return $expensesQuery
            ->whereYear('expense_date', Carbon::now()->year)
            ->whereMonth('expense_date', Carbon::now()->month)
            ->with(['categories', 'assignedToUser'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Amount',
            'Category',
            'Description',
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
            $expense->purchase_from ?? 'N/A',
        ];
    }
}
