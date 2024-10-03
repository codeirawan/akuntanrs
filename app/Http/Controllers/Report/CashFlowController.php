<?php

namespace App\Http\Controllers\Report;

use App\Models\Transaction\Receipt;
use App\Models\Transaction\Payment;
use App\Http\Controllers\Controller;
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

        // Aggregate data for cash inflows and outflows
        $cashInflows = Receipt::whereBetween('receipt_date', [$selectedStartDate, $selectedEndDate])->sum('amount');
        $cashOutflows = Payment::whereBetween('payment_date', [$selectedStartDate, $selectedEndDate])->sum('amount');

        // Calculate net cash flow
        $netCashFlow = $cashInflows - $cashOutflows;

        return view('report.cash-flow.index', compact('cashInflows', 'cashOutflows', 'netCashFlow', 'selectedStartDate', 'selectedEndDate'));
    }
}
