<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\Account;
use App\Models\Transaction\JournalEntry;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class CashBankController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();

        return view('transaction.cash.index', compact(
            'accounts',
        ));
    }

    public function data()
    {
        // Check permission
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        // Fetch journal entries with related account information and updated/created_by user
        $journalEntries = JournalEntry::select(
            'journal_entries.id',
            'journal_entries.voucher_code',
            'journal_entries.journal_date',
            'journal_entries.account_id',
            'journal_entries.debit',
            'journal_entries.credit',
            'journal_entries.note',
            'journal_entries.created_at',
            'journal_entries.updated_at',
            'journal_entries.updated_by',
            'journal_entries.created_by',
            'updatedUser.name as updated_by_name',  // Name of the user who updated
            'createdUser.name as created_by_name'   // Name of the user who created
        )
            ->with('account:id,account_code,sub_account_name') // Fetch account relationship
            ->leftJoin('users as updatedUser', 'journal_entries.updated_by', '=', 'updatedUser.id') // Join with users table for updated_by
            ->leftJoin('users as createdUser', 'journal_entries.created_by', '=', 'createdUser.id') // Join with users table for created_by
            ->where(function ($query) {
                $query->where('voucher_code', 'like', 'RV%')
                    ->orWhere('voucher_code', 'like', 'PV%');
            })
            ->orderByDesc('journal_entries.created_at')
            ->get();

        // Create DataTables instance
        return DataTables::of($journalEntries)
            ->addColumn('journal_date', function ($entry) {
                return $entry['journal_date'] ? \Carbon\Carbon::parse($entry['journal_date'])->format('d-m-Y') : '-';
            })
            ->addColumn('account', function ($entry) {
                return $entry->account ? $entry->account->account_code . ' ' . $entry->account->sub_account_name : '';
            })
            ->addColumn('debit', function ($entry) {
                return $entry['debit'] != 0 ? number_format($entry['debit'], 2, ',', '.') : '';
            })
            ->addColumn('credit', function ($entry) {
                return $entry['credit'] != 0 ? number_format($entry['credit'], 2, ',', '.') : '';
            })
            ->addColumn('note', function ($entry) {
                return $entry['note'] ?? ''; // Handle null notes
            })
            ->addColumn('updated', function ($entry) {
                // If updated_by is null, use created_by and its date
                if ($entry['updated_by']) {
                    $updatedDate = $entry['updated_at'] ? \Carbon\Carbon::parse($entry['updated_at'])->format('d-m-Y') : '-';
                    $updatedBy = $entry['updated_by_name'] ?? 'Unknown';
                    return $updatedDate . '<br>by ' . $updatedBy;

                } else {
                    $createdDate = $entry['created_at'] ? \Carbon\Carbon::parse($entry['created_at'])->format('d-m-Y') : '-';
                    $createdBy = $entry['created_by_name'] ?? 'Unknown';
                    return $createdDate . '<br>by ' . $createdBy;
                }
            })
            ->addColumn('action', function ($journalEntry) {
                $edit = '<a href="' . route('cash.edit', $journalEntry->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                return (Laratrust::isAbleTo('update-transaction') ? $edit : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();

        return view('transaction.cash.create', compact(
            'accounts',
        ));

    }

    public function store(Request $request)
    {
        // Check permissions
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        // Validate the incoming request data
        $this->validate($request, [
            'receipt_date' => [$request->receipts ? 'required' : 'nullable', 'date_format:d-m-Y'],
            'receipts' => [$request->receipts ? 'required' : 'nullable', 'array', 'min:1'],
            'receipts.*.account_id' => ['required_with:receipts', 'exists:accounts,id'],
            'receipts.*.amount' => ['nullable', 'regex:/^\d{1,3}(?:\.\d{3})*(?:,\d{2})?$/'],
            'receipts.*.note' => ['nullable', 'string'],

            'payment_date' => [$request->payments ? 'required' : 'nullable', 'date_format:d-m-Y'],
            'payments' => [$request->payments ? 'required' : 'nullable', 'array', 'min:1'],
            'payments.*.account_id' => ['required_with:payments', 'exists:accounts,id'],
            'payments.*.amount' => ['nullable', 'regex:/^\d{1,3}(?:\.\d{3})*(?:,\d{2})?$/'],
            'payments.*.note' => ['nullable', 'string'],
        ]);

        // Check which type of entry is being processed (receipts or payments)
        $isReceipt = !empty($request->receipts);
        $isPayment = !empty($request->payments);

        // Sanitize and save entries
        if ($isReceipt) {
            $journalDate = $request->receipt_date
                ? Carbon::createFromFormat('d-m-Y', $request->receipt_date)->format('Y-m-d')
                : now()->format('Y-m-d');

            // Generate a voucher code for receipts
            $voucherCode = JournalEntry::generateVoucherCode('RV');

            foreach ($request->receipts as $receipt) {
                $journalEntry = new JournalEntry;
                $journalEntry->journal_date = $journalDate; // Use the same journal date
                $journalEntry->voucher_code = $voucherCode; // Use the same voucher code
                $journalEntry->account_id = $receipt['account_id'];
                $journalEntry->debit = floatval(str_replace([','], [''], $receipt['amount'] ?? 0)); // Convert amount to float
                $journalEntry->credit = 0; // Since it's a receipt, set credit to 0
                $journalEntry->note = $receipt['note'] ?? null;
                $journalEntry->created_by = auth()->user()->id;
                $journalEntry->save();
            }

            // Success message for receipts
            $message = Lang::get('Receipt') . ' \'' . $voucherCode . '\' ' . Lang::get('successfully created.');
        } elseif ($isPayment) {
            $journalDate = $request->payment_date
                ? Carbon::createFromFormat('d-m-Y', $request->payment_date)->format('Y-m-d')
                : now()->format('Y-m-d');

            // Generate a voucher code for payments
            $voucherCode = JournalEntry::generateVoucherCode('PV');

            foreach ($request->payments as $payment) {
                $journalEntry = new JournalEntry;
                $journalEntry->journal_date = $journalDate; // Use the same journal date
                $journalEntry->voucher_code = $voucherCode; // Use the same voucher code
                $journalEntry->account_id = $payment['account_id'];
                $journalEntry->debit = 0; // Since it's a payment, set debit to 0
                $journalEntry->credit = floatval(str_replace([','], [''], $payment['amount'] ?? 0)); // Convert amount to float
                $journalEntry->note = $payment['note'] ?? null;
                $journalEntry->created_by = auth()->user()->id;
                $journalEntry->save();
            }

            // Success message for payments
            $message = Lang::get('Payment') . ' \'' . $voucherCode . '\' ' . Lang::get('successfully created.');
        } else {
            return redirect()->back()->withErrors(['msg' => Lang::get('No entries to process.')])->withInput();
        }

        // Redirect with success message
        return redirect()->route('cash.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();

        $journal = JournalEntry::findOrFail($id);
        // dd($journal);

        if ($journal->journal_date) {
            $journal->journal_date = \Carbon\Carbon::parse($journal->journal_date)->format('d-m-Y');
        }

        // Retrieve journals that match the voucher code and are not marked as deleted
        $journals = JournalEntry::where('voucher_code', $journal->voucher_code)
            ->whereNull('deleted_at') // Only get entries where deleted_at is null
            ->get();

        return view('transaction.cash.edit', compact('accounts', 'journal', 'journals'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        // Check if the delete all button was pressed
        if ($request->input('action') === 'delete_all') {
            // Get all entry IDs from the request
            $entryIds = array_column($request->entries, 'id');

            // Delete all journal entries for the given entry IDs
            JournalEntry::whereIn('id', $entryIds)->delete();

            // Return success message and redirect to the index page
            $message = Lang::get('All journal entries deleted successfully.');
            return redirect()->route('cash.index')->with('status', $message);
        } else {

            // Validate the request input
            $this->validate($request, [
                'journal_date' => ['required', 'date_format:d-m-Y'],
                'entries' => ['required', 'array', 'min:2'], // At least 2 accounts (debit and credit)
                'entries.*.account_id' => ['required', 'exists:accounts,id'],
                'entries.*.debit' => ['nullable', 'numeric'],
                'entries.*.credit' => ['nullable', 'numeric'],
                'entries.*.note' => ['nullable', 'string'],
                'entries.*.is_remove' => ['nullable', 'boolean'], // Add validation for is_remove flag
            ]);

            // Custom validation to check for duplicate account IDs
            $accountIds = [];
            foreach ($request->entries as $entry) {
                if (in_array($entry['account_id'], $accountIds)) {
                    return redirect()->back()->withErrors(['msg' => Lang::get('Do not use duplicate accounts.')])->withInput();
                }
                $accountIds[] = $entry['account_id'];
            }

            // Filter out entries marked for removal
            $filteredEntries = array_filter($request->entries, function ($entry) {
                return !isset($entry['is_remove']) || $entry['is_remove'] != 1;
            });

            $totalDebit = array_sum(array_column($filteredEntries, 'debit'));
            $totalCredit = array_sum(array_column($filteredEntries, 'credit'));

            // Ensure that total debit equals total credit
            if ($totalDebit != $totalCredit) {
                return redirect()->back()->withErrors(['msg' => 'Total debit must equal total credit'])->withInput();
            }

            // Find the journal entry by ID
            $journal = JournalEntry::findOrFail($id); // Change to use $id from the route

            // Use a transaction to ensure data consistency
            \DB::transaction(function () use ($request, $journal) {
                // Update the main journal date
                $journal->journal_date = $request->journal_date
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->journal_date)->format('Y-m-d')
                    : now();
                $journal->updated_by = auth()->user()->id;
                $journal->save();

                // Loop through the entries and process them
                foreach ($request->entries as $entry) {
                    // If the entry has a 'is_remove' flag set to '1', handle deletion logic
                    if (isset($entry['is_remove']) && $entry['is_remove'] == '1') {
                        if (isset($entry['id'])) {
                            // If the entry has an ID, mark it as deleted
                            $journalEntry = JournalEntry::find($entry['id']);
                            if ($journalEntry) {
                                $journalEntry->deleted_at = now(); // Set the deleted_at timestamp
                                $journalEntry->save();
                            }
                        }
                        continue; // Skip this entry
                    }

                    // Check if the journal entry has an 'id', if not, it's a new entry
                    if (isset($entry['id'])) {
                        // Find the existing journal entry
                        $journalEntry = JournalEntry::find($entry['id']);
                    } else {
                        // Create a new journal entry if 'id' doesn't exist
                        $journalEntry = new JournalEntry;
                        $journalEntry->voucher_code = $journal->voucher_code; // Assign voucher code for new entry
                        $journalEntry->created_by = auth()->user()->id;
                    }

                    // Set the values for each journal entry
                    $journalEntry->journal_date = $journal->journal_date;
                    $journalEntry->account_id = $entry['account_id'];
                    $journalEntry->debit = $entry['debit'] ?? 0;
                    $journalEntry->credit = $entry['credit'] ?? 0;
                    $journalEntry->note = $entry['note'] ?? null;
                    $journalEntry->updated_by = auth()->user()->id;

                    // Save the journal entry (whether it's an update or a new one)
                    $journalEntry->save();
                }
            });

            // Return success message and redirect to the index page
            $message = Lang::get('Journal Entry') . ' \'' . $journal->voucher_code . '\' ' . Lang::get('successfully updated.');
            return redirect()->route('cash.index')->with('status', $message);
        }
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-transaction')) {
            return abort(404);
        }

        $journalEntry = JournalEntry::findOrFail($id);
        $voucherCode = $journalEntry->voucher_code;
        $journalEntry->delete();

        $message = Lang::get('Journal Entry') . ' \'' . $voucherCode . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('cash.index')->with('status', $message);
    }

    private static function generateVoucherCode()
    {
        // Get current year and month
        $currentDate = Carbon::now();
        $year = $currentDate->year;
        $month = $currentDate->format('m');  // Two-digit month

        // Get the latest journal entry for the current year and month, including soft-deleted entries
        $latestJournalEntry = JournalEntry::whereYear('journal_date', $year)
            ->whereMonth('journal_date', $month)
            ->orderBy('voucher_code', 'desc')
            ->withTrashed() // Include soft-deleted entries
            ->first();

        // Determine the next increment number (XXX part)
        if ($latestJournalEntry) {
            // Extract the last 3 digits from the latest voucher_code and increment it
            $lastIncrement = (int) substr($latestJournalEntry->voucher_code, -3);
            $nextIncrement = str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);  // Increment and pad to 3 digits
        } else {
            // Start with 001 if no previous entries exist for the current month
            $nextIncrement = '001';
        }

        // Generate voucher_code in the format JV-YYYYMM-XXX
        return 'JV-' . $year . $month . '-' . $nextIncrement;
    }
}
