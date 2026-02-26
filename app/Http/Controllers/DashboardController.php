<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request, TransactionService $transactionService)
    {
        $user = $request->user();
        $now = now();

        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $defaultEndDate = $now->toDateString();
        $defaultStartDate = $now->copy()->subDays(29)->toDateString();

        $startDate = Carbon::parse($validated['start_date'] ?? $defaultStartDate)->startOfDay();
        $endDate = Carbon::parse($validated['end_date'] ?? $defaultEndDate)->endOfDay();

        $summary = $transactionService->getMonthlySummary($user->id, $now->month, $now->year);
        $totalBalance = $transactionService->getTotalBalance($user->id);

        $dailyAggregates = Transaction::query()
            ->selectRaw('DATE(transaction_date) as day')
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income_total")
            ->selectRaw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense_total")
            ->where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $dailyMap = [];
        foreach ($dailyAggregates as $aggregate) {
            $dailyMap[$aggregate->day] = [
                'income' => (float) $aggregate->income_total,
                'expense' => (float) $aggregate->expense_total,
            ];
        }

        $chartLabels = [];
        $incomeSeries = [];
        $expenseSeries = [];

        foreach (CarbonPeriod::create($startDate->copy()->startOfDay(), $endDate->copy()->startOfDay()) as $day) {
            $dateKey = $day->toDateString();
            $income = $dailyMap[$dateKey]['income'] ?? 0;
            $expense = $dailyMap[$dateKey]['expense'] ?? 0;

            $chartLabels[] = $day->format('M d');
            $incomeSeries[] = round($income, 2);
            $expenseSeries[] = round($expense, 2);
        }

        $categoryBreakdown = Transaction::query()
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name as category_name')
            ->selectRaw('SUM(transactions.amount) as total')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $categoryLabels = $categoryBreakdown->pluck('category_name')->toArray();
        $categorySeries = $categoryBreakdown
            ->pluck('total')
            ->map(fn ($value) => round((float) $value, 2))
            ->toArray();

        $rangeIncome = array_sum($incomeSeries);
        $rangeExpense = array_sum($expenseSeries);
        $rangeNet = $rangeIncome - $rangeExpense;

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'summary',
            'totalBalance',
            'recentTransactions',
            'startDate',
            'endDate',
            'chartLabels',
            'incomeSeries',
            'expenseSeries',
            'categoryLabels',
            'categorySeries',
            'rangeIncome',
            'rangeExpense',
            'rangeNet'
        ));
    }
}
