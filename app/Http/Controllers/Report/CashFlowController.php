<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\JournalEntry;
use Illuminate\Http\Request;

class CashFlowController extends Controller
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
            return redirect()->route('cash-flow.index');
        }

        // Aggregate cash inflows (debits) and outflows (credits) from journal entries
        $cashInflows = JournalEntry::whereBetween('journal_date', [$selectedStartDate, $selectedEndDate])
            ->sum('debit'); // Sum of debits for cash inflows

        $cashOutflows = JournalEntry::whereBetween('journal_date', [$selectedStartDate, $selectedEndDate])
            ->sum('credit'); // Sum of credits for cash outflows

        // Calculate net cash flow
        $netCashFlow = $cashInflows - $cashOutflows;

        return view('report.cash-flow.index', compact('cashInflows', 'cashOutflows', 'netCashFlow', 'selectedStartDate', 'selectedEndDate'));
    }
}
