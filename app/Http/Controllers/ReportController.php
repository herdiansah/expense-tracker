<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('reports.index', compact('categories'));
    }

    public function export(Request $request)
    {
        // CODE-01: Validate all filter inputs
        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('user_id', auth()->id())],
            'type'       => ['nullable', 'string', Rule::in(['income', 'expense'])],
        ]);

        $query = Transaction::where('user_id', auth()->id())->with('category');

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        $csvFileName = 'transactions_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $symbol = self::currencySymbol(auth()->user()->currency);

        $callback = function() use($transactions, $symbol) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Date', 'Type', 'Category', 'Amount (' . $symbol . ')', 'Description', 'Payment Method']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->transaction_date->format('Y-m-d'),
                    ucfirst($transaction->type),
                    self::sanitizeCsvField($transaction->category->name),
                    ($transaction->type === 'income' ? '' : '-') . $transaction->amount,
                    self::sanitizeCsvField($transaction->description),
                    self::sanitizeCsvField($transaction->payment_method ?? 'N/A')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * SEC-04: Sanitize CSV fields to prevent formula injection.
     * Prefix dangerous characters with a single quote.
     */
    private static function sanitizeCsvField(string $value): string
    {
        $dangerousChars = ['=', '+', '-', '@', "\t", "\r", "\n"];

        if (strlen($value) > 0 && in_array($value[0], $dangerousChars, true)) {
            return "'" . $value;
        }

        return $value;
    }

    /**
     * LOW-01: Centralized currency symbol resolver.
     */
    public static function currencySymbol(?string $currency): string
    {
        $map = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'IDR' => 'Rp',
            'AUD' => 'A$',
            'CAD' => 'C$',
        ];

        return $map[$currency] ?? '$';
    }
}
