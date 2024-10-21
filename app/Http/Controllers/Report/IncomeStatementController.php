<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\JournalEntry;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
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
            return redirect()->route('income-statement.index');
        }

        // Fetch journal entries for the selected date range
        $journalEntries = JournalEntry::whereBetween('journal_date', [$selectedStartDate, $selectedEndDate])
            ->where(function ($query) {
                $query->where('voucher_code', 'like', 'RV%')
                    ->orWhere('voucher_code', 'like', 'PV%');
            })
            ->get();

        // Calculate incomes and expenses
        $incomes = $journalEntries->sum(function ($entry) {
            return (float) $entry->debit; // Cast debit to float for accurate sum
        });

        $expenses = $journalEntries->sum(function ($entry) {
            return (float) $entry->credit; // Cast credit to float for accurate sum
        });

        // Calculate the net income
        $netIncome = $incomes - $expenses;

        // Pass data to the view
        return view('report.income-statement.index', compact('incomes', 'expenses', 'netIncome', 'selectedStartDate', 'selectedEndDate'));
    }
}
