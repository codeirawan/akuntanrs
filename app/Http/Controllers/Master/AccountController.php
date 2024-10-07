<?php

namespace App\Http\Controllers\Master;

use Laratrust;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Account;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class AccountController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.account.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $accounts = Account::select('id', 'account_name', 'sub_account_name', 'account_code', 'account_type', 'is_debit', 'is_credit', 'bs_flag', 'pl_flag', 'opening_balance', 'opening_balance_date', 'is_active')
            ->orderBy('account_code')->get();

        return DataTables::of($accounts)
            ->addColumn('account_type', function ($account) {
                $accountTypes = [
                    1 => 'Liquid Asset',
                    2 => 'Fixed Asset',
                    3 => 'Liability',
                    4 => 'Equity',
                    5 => 'Income',
                    6 => 'Expense',
                    7 => 'Other',
                ];
                return ucfirst($accountTypes[$account->account_type] ?? 'Other');
            })
            ->addColumn('opening_balance', function ($account) {
                // Format opening balance as 1.000.899,98
                return number_format($account->opening_balance, 2, ',', '.');
            })
            ->addColumn('opening_balance_date', function ($account) {
                // Format the date as dd/mm/yyyy
                return $account->opening_balance_date ? \Carbon\Carbon::parse($account->opening_balance_date)->format('d/m/Y') : '-';
            })
            ->addColumn('action', function ($account) {
                $edit = '<a href="' . route('master.account.edit', $account->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.account.destroy', $account->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $account->account_name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('update-master') ? $edit : '') . (Laratrust::isAbleTo('delete-master') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        return view('master.account.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        // Validate request data
        $validatedData = $this->validate($request, [
            'account_name' => ['required', 'string', 'max:191'],
            'sub_account_name' => ['required', 'string', 'max:191'],
            'account_code' => ['required', 'string', 'max:191', 'unique:accounts,account_code'],
            'account_type' => ['required', 'integer', 'between:1,7'],
            'is_debit' => ['nullable', 'boolean'],
            'is_credit' => ['nullable', 'boolean'],
            'bs_flag' => ['nullable', 'boolean'],
            'pl_flag' => ['nullable', 'boolean'],
            'opening_balance' => ['nullable', 'numeric', 'min:0'],
            'opening_balance_date' => ['nullable', 'date_format:d-m-Y'],
        ]);

        // Set flags to their default values
        $isDebit = $request->has('is_debit') ? 1 : 0;
        $isCredit = $request->has('is_credit') ? 1 : 0;
        $bsFlag = $request->has('bs_flag') ? 1 : 0;
        $plFlag = $request->has('pl_flag') ? 1 : 0;

        // Validate debit/credit and bs/pl flags logic
        if ($request->is_debit && $request->is_credit) {
            return redirect()->back()->withInput()->withErrors(['is_debit' => 'Only one of Is Debit or Is Credit can be selected.']);
        }
        if (!$request->is_debit && !$request->is_credit) {
            return redirect()->back()->withInput()->withErrors(['is_debit' => 'At least one of Is Debit or Is Credit must be selected.']);
        }
        if ($request->bs_flag && $request->pl_flag) {
            return redirect()->back()->withInput()->withErrors(['bs_flag' => 'Only one of Balance Sheet Flag or Profit/Loss Flag can be selected.']);
        }
        if (!$request->bs_flag && !$request->pl_flag) {
            return redirect()->back()->withInput()->withErrors(['bs_flag' => 'At least one of Balance Sheet Flag or Profit/Loss Flag must be selected.']);
        }

        try {
            // Create a new account
            $account = Account::create([
                'account_name' => $validatedData['account_name'],
                'sub_account_name' => $validatedData['sub_account_name'],
                'account_code' => $validatedData['account_code'],
                'account_type' => $validatedData['account_type'],
                'is_debit' => $isDebit,
                'is_credit' => $isCredit,
                'bs_flag' => $bsFlag,
                'pl_flag' => $plFlag,
                'opening_balance' => $validatedData['opening_balance'] ?? 0,
                'opening_balance_date' => $validatedData['opening_balance_date'] ? Carbon::createFromFormat('d-m-Y', $validatedData['opening_balance_date'])->format('Y-m-d') : null,
                'is_active' => 1,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            $message = Lang::get('Account') . ' \'' . $account->account_name . '\' ' . Lang::get('successfully created.');
            return redirect()->route('master.account.index')->with('status', $message);
        } catch (\Exception $e) {
            \Log::error('Error creating account: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => auth()->user()->id,
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => Lang::get('Failed to create account. Please try again.')]);
        }
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $account = Account::findOrFail($id);

        return view('master.account.edit', compact('account'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        // Validate request data
        $validatedData = $this->validate($request, [
            'account_name' => ['required', 'string', 'max:191'],
            'sub_account_name' => ['required', 'string', 'max:191'],
            'account_code' => ['required', 'string', 'max:191', 'unique:accounts,account_code,' . $id],
            'account_type' => ['required', 'integer', 'between:1,7'],
            'is_debit' => ['nullable', 'boolean'],
            'is_credit' => ['nullable', 'boolean'],
            'bs_flag' => ['nullable', 'boolean'],
            'pl_flag' => ['nullable', 'boolean'],
            'opening_balance' => ['nullable', 'numeric', 'min:0'],
            'opening_balance_date' => ['nullable', 'date_format:d-m-Y'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Set flags to their default values
        $isDebit = $request->has('is_debit') ? 1 : 0;
        $isCredit = $request->has('is_credit') ? 1 : 0;
        $bsFlag = $request->has('bs_flag') ? 1 : 0;
        $plFlag = $request->has('pl_flag') ? 1 : 0;
        $isActive = $request->has('is_active') ? 1 : 0;

        // Validate that either is_debit or is_credit is true but not both
        if ($request->is_debit && $request->is_credit) {
            return redirect()->back()->withInput()->withErrors(['is_debit' => 'Only one of Is Debit or Is Credit can be selected.']);
        }
        if (!$request->is_debit && !$request->is_credit) {
            return redirect()->back()->withInput()->withErrors(['is_debit' => 'At least one of Is Debit or Is Credit must be selected.']);
        }

        // Validate that either bs_flag or pl_flag is true but not both
        if ($request->bs_flag && $request->pl_flag) {
            return redirect()->back()->withInput()->withErrors(['bs_flag' => 'Only one of Balance Sheet Flag or Profit/Loss Flag can be selected.']);
        }
        if (!$request->bs_flag && !$request->pl_flag) {
            return redirect()->back()->withInput()->withErrors(['bs_flag' => 'At least one of Balance Sheet Flag or Profit/Loss Flag must be selected.']);
        }

        try {
            // Retrieve the account to update or fail if not found
            $account = Account::findOrFail($id);

            // Update account fields with validated data
            $account->update([
                'account_name' => $validatedData['account_name'],
                'sub_account_name' => $validatedData['sub_account_name'],
                'account_code' => $validatedData['account_code'],
                'account_type' => $validatedData['account_type'],
                'is_debit' => $isDebit,
                'is_credit' => $isCredit,
                'bs_flag' => $bsFlag,
                'pl_flag' => $plFlag,
                'opening_balance' => $validatedData['opening_balance'] ?? 0,
                'opening_balance_date' => $validatedData['opening_balance_date'] ? Carbon::createFromFormat('d-m-Y', $validatedData['opening_balance_date'])->format('Y-m-d') : null,
                'is_active' => $isActive,
                'updated_by' => auth()->user()->id,
            ]);

            // Prepare success message
            $message = Lang::get('Account') . ' \'' . $account->account_name . '\' ' . Lang::get('successfully updated.');
            return redirect()->route('master.account.index')->with('status', $message);
        } catch (\Exception $e) {
            // Handle exceptions
            \Log::error('Error updating account: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => auth()->user()->id,
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => Lang::get('Failed to update account. Please try again.')]);
        }
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $account = Account::findOrFail($id);
        $name = $account->account_name;
        $account->updated_by = auth()->user()->id;
        $account->save();
        $account->delete();

        $message = Lang::get('Account') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.account.index')->with('status', $message);
    }
}
