<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Get the monthly summary for a user (total income, total expense)
     *
     * @param int $userId
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getMonthlySummary(int $userId, int $month, int $year): array
    {
        $summary = Transaction::where('user_id', $userId)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->selectRaw("
                SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as total_expense
            ")
            ->first();

        return [
            'total_income' => (float) ($summary->total_income ?? 0),
            'total_expense' => (float) ($summary->total_expense ?? 0),
            'net_balance' => (float) (($summary->total_income ?? 0) - ($summary->total_expense ?? 0)),
        ];
    }

    /**
     * Calculate total balance of a user across all time
     * 
     * @param int $userId
     * @return float
     */
    public function getTotalBalance(int $userId): float
    {
        $summary = Transaction::where('user_id', $userId)
            ->selectRaw("
                SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as total_expense
            ")
            ->first();

        return (float) (($summary->total_income ?? 0) - ($summary->total_expense ?? 0));
    }
}
