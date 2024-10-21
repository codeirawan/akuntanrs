<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\JournalEntry;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function index(Request $request)
    {
        // Get selected filters from the session if they exist
        $selectedStartDate = $request->session()->get('selected_start_date', now()->startOfMonth()->toDateString());
        $selectedEndDate = $request->session()->get('selected_end_date', now()->endOfMonth()->toDateString());

        // Check if filters are applied via the form
        if ($request->isMethod('get') && ($request->input('start_date') || $request->input('end_date'))) {
            // Store selected filters in the session
            $request->session()->put('selected_start_date', $request->input('start_date'));
            $request->session()->put('selected_end_date', $request->input('end_date'));

            // Redirect to the clean URL to avoid showing query parameters
            return redirect()->route('balance-sheet.index');
        }

        // Aggregate data for balance sheet using JournalEntry model
        $assets = JournalEntry::whereHas('account', function ($query) {
            $query->whereIn('account_type', [1, 2]); // Liquid and fixed assets
        })
            ->whereBetween('journal_date', [$selectedStartDate, $selectedEndDate])
            ->sum('debit'); // Summing debits for assets

        $liabilities = JournalEntry::whereHas('account', function ($query) {
            $query->where('account_type', 3); // Liabilities
        })
            ->whereBetween('journal_date', [$selectedStartDate, $selectedEndDate])
            ->sum('credit'); // Summing credits for liabilities

        $equity = JournalEntry::whereHas('account', function ($query) {
            $query->where('account_type', 4); // Equity
        })
            ->whereBetween('journal_date', [$selectedStartDate, $selectedEndDate])
            ->sum('credit'); // Summing credits for equity

        // Calculate total equity as assets - liabilities
        $totalEquity = $assets - $liabilities;

        // Pass data to the view
        return view('report.balance-sheet.index', compact('assets', 'liabilities', 'totalEquity', 'selectedStartDate', 'selectedEndDate'));
    }
}
