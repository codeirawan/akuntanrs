<?php

namespace App\Http\Controllers\Transaction;

use Lang;
use Laratrust;
use DataTables;
use App\Models\Master\Unit;
use Illuminate\Http\Request;
use App\Models\Master\Account;
use App\Models\Master\Cashier;
use App\Models\Master\Patient;
use App\Models\Master\Service;
use App\Http\Controllers\Controller;

class CashierController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        return view('transaction.cashier.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        $cashiers = Cashier::select('id', 'voucher', 'account_id', 'unit_id', 'amount', 'transaction_type', 'date', 'payment_status');

        return DataTables::of($cashiers)
            ->addColumn('transaction_type', function ($cashier) {
                return ucfirst($cashier->transaction_type);
            })
            ->addColumn('payment_status', function ($cashier) {
                return $cashier->payment_status == 'paid' ? Lang::get('Paid') : Lang::get('Unpaid');
            })
            ->addColumn('action', function ($cashier) {
                $edit = '<a href="' . route('transaction.cashier.edit', $cashier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('transaction.cashier.destroy', $cashier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $cashier->voucher . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('update-transaction') ? $edit : '') . (Laratrust::isAbleTo('delete-transaction') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(403, 'Unauthorized action.');
        }

        $accounts = Account::all();
        $units = Unit::all();
        $services = Service::all();
        $patients = Patient::all();

        return view('transaction.cashier.create', compact('accounts', 'units', 'services', 'patients'));
    }


    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        $this->validate($request, [
            'voucher' => ['required', 'string', 'max:191'],
            'account_id' => ['required', 'exists:accounts,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_type' => ['required', 'in:income,expense'],
            'date' => ['required', 'date'],
            'payment_status' => ['required', 'in:paid,unpaid'],
        ]);

        $cashier = new Cashier;
        $cashier->voucher = $request->voucher;
        $cashier->account_id = $request->account_id;
        $cashier->unit_id = $request->unit_id;
        $cashier->amount = $request->amount;
        $cashier->transaction_type = $request->transaction_type;
        $cashier->date = $request->date;
        $cashier->payment_status = $request->payment_status;
        $cashier->created_by = auth()->user()->id;
        $cashier->save();

        $message = Lang::get('Cashier transaction') . ' \'' . $cashier->voucher . '\' ' . Lang::get('successfully created.');
        return redirect()->route('transaction.cashier.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $cashier = Cashier::findOrFail($id);

        return view('transaction.cashier.edit', compact('cashier'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $cashier = Cashier::findOrFail($id);

        $this->validate($request, [
            'voucher' => ['required', 'string', 'max:191'],
            'account_id' => ['required', 'exists:accounts,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_type' => ['required', 'in:income,expense'],
            'date' => ['required', 'date'],
            'payment_status' => ['required', 'in:paid,unpaid'],
        ]);

        $cashier->voucher = $request->voucher;
        $cashier->account_id = $request->account_id;
        $cashier->unit_id = $request->unit_id;
        $cashier->amount = $request->amount;
        $cashier->transaction_type = $request->transaction_type;
        $cashier->date = $request->date;
        $cashier->payment_status = $request->payment_status;
        $cashier->updated_by = auth()->user()->id;
        $cashier->save();

        $message = Lang::get('Cashier transaction') . ' \'' . $cashier->voucher . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('transaction.cashier.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-transaction')) {
            return abort(404);
        }

        $cashier = Cashier::findOrFail($id);
        $voucher = $cashier->voucher;
        $cashier->delete();

        $message = Lang::get('Cashier transaction') . ' \'' . $voucher . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('transaction.cashier.index')->with('status', $message);
    }
}
