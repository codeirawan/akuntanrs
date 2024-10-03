<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Master\Account;
use App\Models\Transaction\Payment;
use App\Models\Transaction\Receipt;
use Illuminate\Http\Request;

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

        // Get all accounts
        $accounts = Account::all();
        $trialBalance = [];

        // Calculate balances for each account
        foreach ($accounts as $account) {
            $debit = Receipt::where('account_id', $account->id)
                ->whereBetween('receipt_date', [$selectedStartDate, $selectedEndDate])
                ->sum('amount');

            $credit = Payment::where('account_id', $account->id)
                ->whereBetween('payment_date', [$selectedStartDate, $selectedEndDate])
                ->sum('amount');

            $trialBalance[] = [
                'account' => $account,
                'debit' => $debit,
                'credit' => $credit,
            ];
        }

        return view('report.trial-balance.index', compact('trialBalance', 'selectedStartDate', 'selectedEndDate'));
    }
}
