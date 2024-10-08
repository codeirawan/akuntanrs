<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Account;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

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

        $accounts = Account::select('id', 'account_name', 'account_code', 'account_type', 'dc_type', 'opening_balance', 'is_active');

        return DataTables::of($accounts)
            ->addColumn('account_type', function ($account) {
                return ucfirst($account->account_type);
            })
            ->addColumn('dc_type', function ($account) {
                return $account->dc_type == 'd' ? 'Debit' : 'Credit';
            })
            ->addColumn('is_active', function ($account) {
                return $account->is_active ? Lang::get('Active') : Lang::get('Inactive');
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

        $this->validate($request, [
            'account_name' => ['required', 'string', 'max:191'],
            'account_code' => ['required', 'string', 'max:191', 'unique:accounts,account_code'],
            'account_type' => ['required', 'in:asset,liability,equity,income,expense'],
            'dc_type' => ['required', 'in:d,c'],
            'opening_balance' => ['required', 'numeric', 'min:0'],
            'opening_balance_date' => ['required', 'date'],
        ]);

        $account = new Account;
        $account->account_name = $request->account_name;
        $account->account_code = $request->account_code;
        $account->account_type = $request->account_type;
        $account->dc_type = $request->dc_type;
        $account->opening_balance = $request->opening_balance;
        $account->opening_balance_date = $request->opening_balance_date;
        $account->is_active = 1;
        $account->created_by = auth()->user()->id;
        $account->save();

        $message = Lang::get('Account') . ' \'' . $account->account_name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.account.index')->with('status', $message);
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

        $account = Account::findOrFail($id);

        $this->validate($request, [
            'account_name' => ['required', 'string', 'max:191'],
            'account_code' => ['required', 'string', 'max:191', 'unique:accounts,account_code,' . $account->id],
            'account_type' => ['required', 'in:asset,liability,equity,income,expense'],
            'dc_type' => ['required', 'in:d,c'],
            'opening_balance' => ['required', 'numeric', 'min:0'],
            'opening_balance_date' => ['required', 'date'],
            // 'is_active' => ['required', 'boolean'],
        ]);

        $account->account_name = $request->account_name;
        $account->account_code = $request->account_code;
        $account->account_type = $request->account_type;
        $account->dc_type = $request->dc_type;
        $account->opening_balance = $request->opening_balance;
        $account->opening_balance_date = $request->opening_balance_date;
        $account->is_active = $request->is_active ? 1 : 0;
        $account->updated_by = auth()->user()->id;
        $account->save();

        $message = Lang::get('Account') . ' \'' . $account->account_name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.account.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $account = Account::findOrFail($id);
        $name = $account->account_name;
        $account->delete();

        $message = Lang::get('Account') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.account.index')->with('status', $message);
    }
}
