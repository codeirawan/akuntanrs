<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Payment;
use App\Models\Transaction\Receipt;
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

        // Aggregate data for balance sheet
        $assets = Receipt::whereHas('account', function ($query) {
            $query->where('account_type', 'asset');
        })->whereBetween('receipt_date', [$selectedStartDate, $selectedEndDate])->sum('amount');

        $liabilities = Payment::whereHas('account', function ($query) {
            $query->where('account_type', 'liability');
        })->whereBetween('payment_date', [$selectedStartDate, $selectedEndDate])->sum('amount');

        // Equity calculation based on net income
        $equity = $assets - $liabilities;

        return view('report.balance-sheet.index', compact('assets', 'liabilities', 'equity', 'selectedStartDate', 'selectedEndDate'));
    }

}
