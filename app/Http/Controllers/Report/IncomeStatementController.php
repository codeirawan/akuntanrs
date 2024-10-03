<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Payment;
use App\Models\Transaction\Receipt;
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

        // Fetch income and expenses for the selected date range
        $incomes = Receipt::whereBetween('receipt_date', [$selectedStartDate, $selectedEndDate])->sum('amount');
        $expenses = Payment::whereBetween('payment_date', [$selectedStartDate, $selectedEndDate])->sum('amount');

        // Calculate the net income
        $netIncome = $incomes - $expenses;

        // Pass data to the view
        return view('report.income-statement.index', compact('incomes', 'expenses', 'netIncome', 'selectedStartDate', 'selectedEndDate'));
    }
}
