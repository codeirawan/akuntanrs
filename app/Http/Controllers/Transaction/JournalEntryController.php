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

class JournalEntryController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        return view('transaction.journal.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        // Step 1: Fetch all journal entries
        $journalEntries = JournalEntry::select(
            'id',
            'voucher_code',
            'journal_date',
            'account_id',
            'debit',
            'credit',
            'note',
            'created_at'
        )
            ->with('account:id,account_name,sub_account_name') // Fetch related account details
            ->where(function ($query) {
                $query->where('voucher_code', 'like', 'JV%');
            })
            ->orderByDesc('voucher_code')
            ->get();

        $result = [];

        // Step 2: Process journal entries to group by voucher code
        foreach ($journalEntries as $entry) {
            // Initialize an entry in the result if it doesn't exist
            if (!isset($result[$entry->voucher_code])) {
                $result[$entry->voucher_code] = [
                    'journal_date' => $entry->journal_date,
                    'voucher_code' => $entry->voucher_code,
                    'debits' => [],
                    'credits' => [],
                    'first_id' => $entry->id, // Store the first ID for actions
                ];
            }

            // Add to debits or credits based on the entry
            if ($entry->debit > 0) {
                $result[$entry->voucher_code]['debits'][] = [
                    'amount' => $entry->debit,
                    'note' => $entry->note,
                    'account' => $entry->account ? $entry->account->sub_account_name : '-',
                    // 'account' => $entry->account ? $entry->account->account_name . '<br>' . $entry->account->sub_account_name : '-',
                    'id' => $entry->id,
                ];
            }

            if ($entry->credit > 0) {
                $result[$entry->voucher_code]['credits'][] = [
                    'amount' => $entry->credit,
                    'note' => $entry->note,
                    'account' => $entry->account ? $entry->account->sub_account_name : '-',
                    // 'account' => $entry->account ? $entry->account->account_name . '<br>' . $entry->account->sub_account_name : '-',
                    'id' => $entry->id,
                ];
            }
        }

        $finalResult = [];
        // Step 3: Build the final result with rows containing 1 debit and 1 credit
        foreach ($result as $voucher) {
            $debitCount = count($voucher['debits']);
            $creditCount = count($voucher['credits']);
            $rowCount = max($debitCount, $creditCount);

            for ($i = 0; $i < $rowCount; $i++) {
                $debit = $voucher['debits'][$i] ?? null;
                $credit = $voucher['credits'][$i] ?? null;

                $finalResult[] = [
                    'journal_date' => $voucher['journal_date'],
                    'voucher_code' => $voucher['voucher_code'],
                    'debit' => $debit ? $debit['amount'] : 0,
                    'credit' => $credit ? $credit['amount'] : 0,
                    'debit_note' => $debit ? $debit['note'] : '',
                    'credit_note' => $credit ? $credit['note'] : '',
                    'accounts_debit' => $debit ? $debit['account'] : '',
                    'accounts_credit' => $credit ? $credit['account'] : '',
                    'first_id' => $debit ? $debit['id'] : ($credit ? $credit['id'] : null),
                ];
            }
        }

        return DataTables::of($finalResult)
            ->addColumn('journal_date', function ($account) {
                // Format the date as dd-mm-yyyy
                return $account['journal_date'] ? \Carbon\Carbon::parse($account['journal_date'])->format('d-m-Y') : '-';
            })
            // Format amounts for debit and credit
            ->addColumn('debit', function ($account) {
                return $account['debit'] ? number_format($account['debit'], 2, ',', '.') : '';
            })
            ->addColumn('credit', function ($account) {
                return $account['credit'] ? number_format($account['credit'], 2, ',', '.') : '';
            })
            // Show debit account information
            ->addColumn('accounts_debit', function ($account) {
                return $account['accounts_debit'] ? $account['accounts_debit'] : '';
            })
            // Show credit account information
            ->addColumn('accounts_credit', function ($account) {
                return $account['accounts_credit'] ? $account['accounts_credit'] : '';
            })
            ->addColumn('action', function ($journalEntry) {
                $edit = '<a href="' . route('journal.edit', $journalEntry['first_id']) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';

                return (Laratrust::isAbleTo('update-transaction') ? $edit : '');
            })
            ->rawColumns(['accounts_debit', 'accounts_credit', 'action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();

        return view('transaction.journal.create', compact(
            'accounts',
        ));

    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        // Validate the incoming request data
        $this->validate($request, [
            'journal_date' => ['required', 'date_format:d-m-Y'],
            'voucher_code' => ['nullable', 'string', 'max:191', 'unique:journal_entries,voucher_code'],
            'entries' => ['required', 'array', 'min:2'], // At least 2 accounts (debit and credit)
            'entries.*.account_id' => ['required', 'exists:accounts,id'],
            'entries.*.debit' => ['nullable', 'numeric'],
            'entries.*.credit' => ['nullable', 'numeric'],
            'entries.*.note' => ['nullable', 'string'],
        ]);

        // Custom validation to check for duplicate account IDs
        $accountIds = [];
        foreach ($request->entries as $entry) {
            if (in_array($entry['account_id'], $accountIds)) {
                return redirect()->back()->withErrors(['msg' => Lang::get('Do not use duplicate accounts.')])->withInput();
            }
            $accountIds[] = $entry['account_id'];
        }

        // Calculate total debit and credit
        $totalDebit = array_sum(array_column($request->entries, 'debit'));
        $totalCredit = array_sum(array_column($request->entries, 'credit'));

        // Ensure total debit equals total credit
        if ($totalDebit != $totalCredit) {
            return redirect()->back()->withErrors(['msg' => Lang::get('Total debit must equal total credit.')])->withInput();
        }

        // Generate or use the provided voucher code
        $voucherCode = $request->voucher_code ?? $this->generateVoucherCode();

        // Save journal entries
        foreach ($request->entries as $entry) {
            $journalEntry = new JournalEntry;
            $journalEntry->journal_date = $request->journal_date ? Carbon::createFromFormat('d-m-Y', $request->journal_date)->format('Y-m-d') : now();
            $journalEntry->voucher_code = $voucherCode;
            $journalEntry->account_id = $entry['account_id'];
            $journalEntry->debit = $entry['debit'] ?? 0;
            $journalEntry->credit = $entry['credit'] ?? 0;
            $journalEntry->note = $entry['note'] ?? null;
            $journalEntry->created_by = auth()->user()->id;
            $journalEntry->save();
        }

        // Success message and redirect
        $message = Lang::get('Journal Entry') . ' \'' . $voucherCode . '\' ' . Lang::get('successfully created.');
        return redirect()->route('journal.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();

        $journal = JournalEntry::findOrFail($id);

        if ($journal->journal_date) {
            $journal->journal_date = \Carbon\Carbon::parse($journal->journal_date)->format('d-m-Y');
        }

        // Retrieve journals that match the voucher code and are not marked as deleted
        $journals = JournalEntry::where('voucher_code', $journal->voucher_code)
            ->whereNull('deleted_at') // Only get entries where deleted_at is null
            ->get();

        return view('transaction.journal.edit', compact('accounts', 'journal', 'journals'));
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
            return redirect()->route('journal.index')->with('status', $message);
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
            return redirect()->route('journal.index')->with('status', $message);
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
        return redirect()->route('journal.index')->with('status', $message);
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
