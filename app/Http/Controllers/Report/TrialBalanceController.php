<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrialBalanceController extends Controller
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
            return redirect()->route('trial-balance.index');
        }

        // Get trial balance by grouping accounts
        $trialBalance = DB::table('journal_entries')
            ->join('accounts', 'journal_entries.account_id', '=', 'accounts.id')
            ->select('accounts.account_name',
                DB::raw('SUM(journal_entries.debit) as total_debit'),
                DB::raw('SUM(journal_entries.credit) as total_credit'))
            ->whereBetween('journal_entries.journal_date', [$selectedStartDate, $selectedEndDate])
            ->groupBy('accounts.account_name')
            ->get();

        return view('report.trial-balance.index', compact('trialBalance', 'selectedStartDate', 'selectedEndDate'));
    }
}
