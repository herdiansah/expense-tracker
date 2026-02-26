<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())->with('category');

        if ($request->filled('type') && in_array($request->type, ['income', 'expense'], true)) {
            $query->where('type', $request->type);
        }
        if ($request->filled('category_id')) {
            // Only filter by category if it belongs to the current user
            $userCategoryIds = Category::where('user_id', auth()->id())->pluck('id');
            if ($userCategoryIds->contains($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
        }
        
        $transactions = $query->orderByDesc('transaction_date')->orderByDesc('id')->paginate(15);
        $categories = Category::where('user_id', auth()->id())->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $request->user()->transactions()->create($request->validated());
        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Not used
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        Gate::authorize('update', $transaction);
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);
        $transaction->update($request->validated());
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        Gate::authorize('delete', $transaction);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
