<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Models\Master\Account;
use App\Http\Controllers\Controller;
use App\Models\Transaction\JournalEntry;

class GeneralLedgerController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::all();

        // Get selected filters from the session if they exist
        $selectedAccount = $request->session()->get('selected_account', 1);
        $selectedMonth = $request->session()->get('selected_month', null);
        $selectedYear = $request->session()->get('selected_year', date('Y'));

        // Check if filters are applied via the form
        if ($request->isMethod('get') && ($request->input('account_id') || $request->input('month') || $request->input('year'))) {
            // Store selected filters in the session
            $request->session()->put('selected_account', $request->input('account_id'));
            $request->session()->put('selected_month', $request->input('month'));
            $request->session()->put('selected_year', $request->input('year'));

            // Redirect to the clean URL to avoid showing query parameters
            return redirect()->route('general-ledger.index');
        }

        // Fetch journal entries based on the selected filters
        $journals = JournalEntry::with('account') // Load related account data
            ->when($selectedAccount, function ($query) use ($selectedAccount) {
                $query->where('account_id', $selectedAccount);
            })
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                $query->whereMonth('journal_date', $selectedMonth);
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereYear('journal_date', $selectedYear);
            })
            ->orderBy('journal_date')
            ->get();

        // Initialize totals
        $totalDebit = 0;
        $totalCredit = 0;

        // Calculate total debit and credit from journal entries
        foreach ($journals as $journal) {
            $totalDebit += $journal->debit;
            $totalCredit += $journal->credit;
        }

        return view('report.general-ledger.index', compact('accounts', 'journals', 'totalDebit', 'totalCredit', 'selectedYear'));
    }
}
