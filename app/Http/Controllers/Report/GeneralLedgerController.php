<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Models\Master\Account;
use App\Http\Controllers\Controller;

class GeneralLedgerController extends Controller
{
    public function index(Request $request)
    {
        // Get selected filters from the session if they exist
        $selectedAccount = $request->session()->get('selected_account', null);
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

        // Fetch accounts with their respective receipts (debit) and payments (credit)
        $accounts = Account::with([
            'receipts' => function ($query) use ($selectedMonth, $selectedYear) {
                if ($selectedMonth) {
                    $query->whereMonth('receipt_date', $selectedMonth);
                }
                $query->whereYear('receipt_date', $selectedYear)
                    ->orderBy('receipt_date');
            },
            'payments' => function ($query) use ($selectedMonth, $selectedYear) {
                if ($selectedMonth) {
                    $query->whereMonth('payment_date', $selectedMonth);
                }
                $query->whereYear('payment_date', $selectedYear)
                    ->orderBy('payment_date');
            }
        ])
            ->when($selectedAccount, function ($query) use ($selectedAccount) {
                $query->where('id', $selectedAccount);
            })
            ->get();

        // Initialize totals
        $totalDebit = 0;
        $totalCredit = 0;

        // Calculate total debit and credit for the selected accounts
        foreach ($accounts as $account) {
            foreach ($account->receipts as $receipt) {
                $totalDebit += $receipt->amount;
            }
            foreach ($account->payments as $payment) {
                $totalCredit += $payment->amount;
            }
        }

        return view('report.general-ledger.index', compact('accounts', 'totalDebit', 'totalCredit', 'selectedYear'));
    }
}
